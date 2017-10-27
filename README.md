# Mastodon API PHP

PHP wrapper for the Mastodon API that includes oAuth helpers, Guzzle based.

[![Build Status](https://travis-ci.org/r-daneelolivaw/mastodon-api-php.png)](https://travis-ci.org/r-daneelolivaw/mastodon-api-php)

@todo UML diagram

_**Still under development**, will be released on Packagist once ready._

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

_Will be published on Packagist once a first release is achieved_

## Mastodon API and instances

This is a plain API wrapper, so the intention is to support further changes in the API by letting the developer pass the desired endpoint.

1. Get the [REST Mastodon documentation](https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md).
2. Get an instance from the [instance list](https://instances.mastodon.xyz/list).

## Quick test 

An interactive demo of the oAuth helper is available.

1. Clone this repository.
2. cd in the cloned directory
2. Run `composer install`
3. Run `php -S localhost:8000`
4. In your browser, go to http://localhost:8000/test.php
5. You will get the client_id and client_secret, click on the authorization URL link, then confirm the authorization under Mastodon and copy the authorization code.
6. Get the bearer: click on the "Get access token" button.
7. Authenticate with your Mastodon username (email) and password: click on "Login".

@todo interactive demo of Mastodon API wrapper.

![Authorize your application](documentation/images/mastodon-authorize.png?raw=true "Authorize your application")

![Authorize your application](documentation/images/mastodon-authorization-code.png?raw=true "Authorization code")


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

### User login

Login with Mastodon email and password.
`$oAuth->authenticateUser($email, $password);`

## Use the Mastodon API

### Instantiate the Mastodon API with the configuration

The oAuth credentials should be stored from the configuration value object for later retrieval.
Then you can use it in this way.

```
$config = new Colorfield\Mastodon\ConfigurationVO();
$config->setClientName($name);
$config->setMastodonInstance($instance);
$config->setClientId('...');
$config->setClientSecret('...');
$config->setBearer('...');
$mastodonAPI = new Colorfield\Mastodon\MastodonAPI($config);
```

### Use the API wrapper

@todo create documentation
