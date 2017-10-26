# Mastodon API PHP

PHP wrapper for the Mastodon API.

_**Still under development**, will be released on Packagist once ready._

## Getting started

To be installed via Composer.

// Once one Packagist

`composer require colorfield/mastodon-api-php`

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

@todo update documentation

## Use the Mastodon API

@todo update documentation
