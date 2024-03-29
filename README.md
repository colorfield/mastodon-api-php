# Mastodon API PHP

PHP wrapper for the Mastodon API, that includes OAuth helpers. Guzzle based.

This is a plain API wrapper, so it makes it more resilient to changes (new parameters, ...) from the API
by letting the developer pass the desired endpoint and parameters.

## Quick start

Install it via Composer.
Latest version requires PHP 8.1. For previous versions of PHP, use `v0.1.0`.

```bash
composer require colorfield/mastodon-api
```

1. Get an instance from the [instance list](https://instances.social).
2. Get endpoints from the Mastodon API documentation: [Getting started with the API](https://docs.joinmastodon.org/client/intro/) and [Guidelines and best practices](https://docs.joinmastodon.org/api/guidelines/)

[Some requests](https://docs.joinmastodon.org/client/public/), like public timelines, do not require any authentication.

### Get public data.

Initialize the API.

```php
$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$config = new Colorfield\Mastodon\ConfigurationVO($name, $instance);
$this->api = new MastodonAPI($config);
```

Request a public endpoint.

```php
$timeline = $this->api->getPublicData('/timelines/public');
```

which is equivalent to

```php
$timeline = $this->api->get('/timelines/public', [], false);
```

where the 3rd parameter indicates that we don't require any authentication.

### Authenticate with OAuth

This is needed for endpoints that are requiring a token.

To get OAuth credentials, a lightweight client is also available in [test_oauth](./test_oauth.php), 
via a local PHP server. It provides the client id, client secret and bearer.
See the [Development](#development) section below.

#### Register your application

```php
$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$oAuth = new Colorfield\Mastodon\MastodonOAuth($name, $instance);
```

The default configuration is limited to the `read` and `write` scopes.
You can modify it via

```php
$oAuth->config->setScopes(['read', 'write', 'follow', 'push']);
```

or alternatively use enum

```php
$oAuth->config->setScopes([
    OAuthScope::read->name, 
    OAuthScope::write->name, 
    OAuthScope::follow->name,
    OAuthScope::push->name
]);
```

Note that this must be done while obtaining the token, so you cannot override this after.
[More about scopes](https://docs.joinmastodon.org/api/oauth-scopes/).

#### Get the authorization code

1. Get the authorization URL `$authorizationUrl = $oAuth->getAuthorizationUrl();`
2. Go to this URL, authorize and copy the authorization code.

#### Get the bearer

1. Store the authorization code in the configuration value object.
`$oAuth->config->setAuthorizationCode(xxx);`

2. Then get the access token. As a side effect, it is store in the Configuration value object.
`$oAuth->getAccessToken();`

### Use the Mastodon API

#### Instantiate the Mastodon API with the configuration

The OAuth credentials should be stored in the Configuration value object for later retrieval.

```php
$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$oAuth = new Colorfield\Mastodon\MastodonOAuth($name, $instance);
$oAuth->config->setClientId('...');
$oAuth->config->setClientSecret('...');
$oAuth->config->setBearer('...');
$mastodonAPI = new Colorfield\Mastodon\MastodonAPI($oAuth->config);
```

#### User login

Login with Mastodon email and password.

```php
$oAuth->authenticateUser($email, $password);
```

#### Get

Get credentials (assumes by default that authentication is provided).

```php
$credentials = $mastodonAPI->get('/accounts/verify_credentials');
```

Get followers

```php
$followers = $mastodonAPI->get('/accounts/USER_ID/followers');
```

#### Post

Clear notifications

```php
$clearedNotifications = $mastodonAPI->post('/notifications/clear');
```

@todo complete with delete, put, patch and stream.

## Development

### Manual testing tools

#### OAuth

An interactive demo is available.

1. Clone the [GitHub repository](https://github.com/colorfield/mastodon-api-php).
2. cd in the cloned directory
2. Run `composer install`
3. Run `php -S localhost:8000`
4. In your browser, go to http://localhost:8000/test_oauth.php
5. You will get the client_id and client_secret, click on the authorization URL link, then confirm the authorization under Mastodon and copy the authorization code.
6. Get the bearer: click on the "Get access token" button.
7. Authenticate with your Mastodon username (email) and password: click on "Login".

![Authorize your application](documentation/images/mastodon-authorize.png?raw=true "Authorize your application")

![Authorize your application](documentation/images/mastodon-authorization-code.png?raw=true "Authorization code")

#### Mastodon API

1. Make a copy of `.env.local` as `.env`
2. Define the information obtained with OAuth and your Mastodon email and password.
3. In your browser, go to http://localhost:8000/test_api.php
