<?php

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
   * @var string
   */
  const DEFAULT_INSTANCE_NAME = 'https://mastodon.social';

  /**
   * @var string
   */
  const API_VERSION = '/api/v1/';

  /**
   * @var string
   */
  const DEFAULT_TIME_OUT = 300;

  /**
   * @var string
   */
  public $baseUrl;

  /**
   * @var mixed
   */
  protected $oAuth;

  /**
   * The HTTP status code from the previous request.
   *
   * @var int
   */
  protected $httpStatusCode;

  /**
   * Create the API access object.
   * Requires the cURL library.
   *
   * @throws \RuntimeException When cURL isn't loaded
   * @throws \InvalidArgumentException When incomplete configuration properties are provided.
   *
   * @param \ConfigurationVO $config
   */
  public function __construct(ConfigurationVO $config)
  {
    if (!function_exists('curl_init'))
    {
      throw new RuntimeException('MastodonAPI requires cURL extension to be loaded, see: http://curl.haxx.se/docs/install.html');
    }

    if(is_null($config->getInstanceName()))
    {
      $config->setInstanceName(self::DEFAULT_INSTANCE_NAME);
    }

    $this->baseUrl = $config->getInstanceName() . self::API_VERSION;
  }

  public function get($endpoint)
  {
    // @todo implement
  }

  public function post($endpoint)
  {
    // @todo implement
  }

  public function delete($endpoint)
  {
    // @todo implement
  }

  public function stream($endpoint)
  {
    // @todo implement
  }

  /**
   * Get the HTTP status code for the previous request
   *
   * @return integer
   */
  public function getHttpStatusCode()
  {
    return $this->httpStatusCode;
  }
}
