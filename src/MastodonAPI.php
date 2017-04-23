<?php

namespace Colorfield\Mastodon;

/**
 * MastodonAPI
 *
 * PHP version 5.5.9
 *
 * @category Third party
 * @package  Mastodon-API-PHP
 * @author   Christophe Jossart <christophe@colorfield.eu>
 * @license  Apache License 2.0
 * @version  0.0.1
 * @link     https://github.com/r-daneelolivaw/mastodon-api-php
 */
class MastodonAPI {

  /**
   * @var mixed
   */
  protected $oAuth;

  /**
   * @var \Colorfield\Mastodon\ConfigurationVO
   */
  private $configVO;

  /**
   * The HTTP status code from the previous request.
   *
   * @var int
   */
  protected $httpStatusCode;

  /**
   * Creates the API access object.
   * Requires the cURL library.
   *
   * @throws \RuntimeException When cURL isn't loaded
   *
   * @param array $config
   */
  public function __construct(array $config) {
    if (!function_exists('curl_init')) {
      // @todo replace cURL by Guzzle to avoid this dependency issue
      throw new \RuntimeException('MastodonAPI requires cURL extension to be loaded, see: http://curl.haxx.se/docs/install.html');
    }

    // Set the value object based on the configuration.
    try {
      $this->configVO = new ConfigurationVO($config);
    }catch (\InvalidArgumentException $exception) {
      print($exception->getMessage());
    }

  }

  public function get($endpoint) {
    // @todo implement
  }

  public function post($endpoint) {
    // @todo implement
  }

  public function delete($endpoint) {
    // @todo implement
  }

  public function stream($endpoint) {
    // @todo implement
  }

  /**
   * Get the HTTP status code for the previous request
   *
   * @return integer
   */
  public function getHttpStatusCode() {
    return $this->httpStatusCode;
  }
}
