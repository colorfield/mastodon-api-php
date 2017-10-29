# Mastodon API PHP

PHP wrapper for the Mastodon API that includes oAuth helpers, Guzzle based.

[![Build Status](https://travis-ci.org/r-daneelolivaw/mastodon-api-php.png)](https://travis-ci.org/r-daneelolivaw/mastodon-api-php)

_Will be published on Packagist once the 0.1.0 release is completed. Get the status on the [issue tracker](https://github.com/r-daneelolivaw/mastodon-api-php/issues?q=is%3Aopen+is%3Aissue+milestone%3A0.1.0)._

## Getting started

To be installed via Composer.

Currently, use this repository:

```
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/r-daneelolivaw/mastodon-api-php"
        }
    ],
    "require": {
        "r-daneelolivaw/mastodon-api-php": "*"
    }
}
```

## Mastodon API and instances

This is a plain API wrapper, so the intention is to support further changes in the API by letting the developer pass the desired endpoint.

1. Get the [REST Mastodon documentation](https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md).
2. Get an instance from the [instance list](https://instances.mastodon.xyz/list).

## Quick test 

### oAuth

An interactive demo is available.

1. Clone this repository.
2. cd in the cloned directory
2. Run `composer install`
3. Run `php -S localhost:8000`
4. In your browser, go to http://localhost:8000/test_oauth.php
5. You will get the client_id and client_secret, click on the authorization URL link, then confirm the authorization under Mastodon and copy the authorization code.
6. Get the bearer: click on the "Get access token" button.
7. Authenticate with your Mastodon username (email) and password: click on "Login".

![Authorize your application](documentation/images/mastodon-authorize.png?raw=true "Authorize your application")

![Authorize your application](documentation/images/mastodon-authorization-code.png?raw=true "Authorization code")

### Mastodon API

1. Make your own copy of _test_credentials.example.php_ as _test_credentials.php_
2. Define in _test_credentials.php_ the information obtained with oAuth and your Mastodon email and password.
3. In your browser, go to http://localhost:8000/test_api.php

## Authenticate with oAuth

### Register your application

Give it a name and an optional instance. 
The instance defaults to mastodon.social.

```
$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$oAuth = new Colorfield\Mastodon\MastodonOAuth($name, $instance);
```

### Get the authorization code

1. Get the authorization URL `$authorizationUrl = $oAuth->getAuthorizationUrl();`
2. Go to this URL, authorize and copy the authorization code.

### Get the bearer

1. Store the authorization code in the configuration value object.
`$oAuth->config->setAuthorizationCode(xxx);`

2. Then get the access token. As a side effect, stores it on the configuration value object.
`$oAuth->getAccessToken;`

## Use the Mastodon API

### Instantiate the Mastodon API with the configuration

The oAuth credentials should be stored from the configuration value object for later retrieval.
Then you can use it in this way.

```
$name = 'MyMastodonApp';
$instance = 'mastodon.social';
$oAuth = new Colorfield\Mastodon\MastodonOAuth($name, $instance);
$oAuth->config->setClientId('...');
$oAuth->config->setClientSecret('...');
$oAuth->config->setBearer('...');
$mastodonAPI = new Colorfield\Mastodon\MastodonAPI($oAuth->config);
```

### User login

Login with Mastodon email and password.
`$oAuth->authenticateUser($email, $password);`

### Use the API wrapper

@todo replace examples by get, post, delete, stream usage.

#### Verify credentials 

```$credentials = $mastodonAPI->get('/accounts/verify_credentials');```

#### Get followers

```$credentials = $mastodonAPI->get('/accounts/USER_ID/followers');```
