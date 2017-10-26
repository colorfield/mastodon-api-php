# Mastodon API PHP

PHP wrapper for the Mastodon API that includes oAuth helpers, Guzzle based.

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

1. Clone this repository.
2. cd in the cloned directory
2. Run `composer install`
3. Run `php -S localhost:8000`
4. In your browser, go to http://localhost:8000/test.php
5. Open the authorization URL, confirm the authorization and copy the token.
6. Get the bearer (@todo)
7. Authenticate with your Mastodon username and password (@todo).

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

@todo create documentation

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
