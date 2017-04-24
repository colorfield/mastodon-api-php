# Mastodon API PHP

PHP wrapper for the Mastodon API.

_**Still under development**, will be released on Packagist once ready._

## Getting started

To be installed via Composer.

## Using the API

This is a wrapper, so the intention is to support further changes in the API by 
letting the developer pass the desired endpoint.

1. Get the [REST Mastodon documentation](https://github.com/tootsuite/documentation/blob/master/Using-the-API/API.md).
2. Get an instance from the [instance list](https://instances.mastodon.xyz/list).

``` 
<?php

$configuration = [
  'instance" => 'https://my.mastodon.instance', // if no instance defined, assume the default one mastodon.social
  'client_id' => '',
  'client_secret' => '',
  'redirect_uri' => '',
  'scopes' => 'read write follow', // one are many, defaults to read if none
  'website' => 'https://colorfield.be', // optional
]; 

$api = new MastodonAPI($configuration); 

// Get as status
$api->get('statuses/1');

// Post a status
$api->post('statuses', ['status' => 'The answer is 42.']);

// Delete a status
$api->delete('statuses/1');
```
