<?php

namespace Colorfield\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

/**
 * MastodonAPI
 *
 * PHP version >= 5.6.0
 *
 * @category Third party
 * @package  Mastodon-API-PHP
 * @author   Christophe Jossart <christophe@colorfield.eu>
 * @license  Apache License 2.0
 * @version  Release: <0.0.1>
 * @link     https://github.com/r-daneelolivaw/mastodon-api-php
 */
class MastodonAPI {

  /**
   * @var \Colorfield\Mastodon\ConfigurationVO
   */
  private $config;

  /**
   * Creates the API object.
   *
   * @param array $config
   */
  public function __construct(ConfigurationVO $config) {
    /** @var \GuzzleHttp\Client client */
    $this->client = new Client();

    try {
      $this->config = $config;
    }catch (\InvalidArgumentException $exception) {
      print($exception->getMessage());
    }
  }

  public function get($endpoint, array $params = []) {
    // @todo implement
  }

  public function post($endpoint, array $params = []) {
    // @todo implement
  }

  public function delete($endpoint, array $params = []) {
    // @todo implement
  }

  public function stream($endpoint) {
    // @todo implement
  }

}
