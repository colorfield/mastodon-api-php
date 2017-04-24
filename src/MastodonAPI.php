<?php

namespace Colorfield\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

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
   * @var \GuzzleHttp\ClientInterface
   */
  private $client;

  /**
   * @var \Colorfield\Mastodon\ConfigurationVO
   */
  private $configVO;


  /**
   * Creates the API object.
   *
   * @param array $config
   */
  public function __construct(array $config) {

    /** @var \GuzzleHttp\Client client */
    $this->client = new Client();

    // Set the value object based on the configuration.
    try {
      $this->configVO = new ConfigurationVO($config);
    }catch (\InvalidArgumentException $exception) {
      print($exception->getMessage());
    }

  }

  public function mastodonGet($endpoint, array $params = []) {
    // @todo implement
  }

  public function mastodonPost($endpoint, array $params = []) {
    // @todo implement
  }

  public function mastodonDelete($endpoint, array $params = []) {
    // @todo implement
  }

  public function mastodonStream($endpoint) {
    // @todo implement
  }

  public function registerApplication() {
    $parameters = [
      'client_name' => $this->configVO->getClientId(),
      'redirect_uris' => $this->configVO->getRedirectUri(),
      'scopes' => $this->configVO->getScopes(),
      'website' => $this->configVO->getWebsite(),
    ];
    $response = $this->client->post(
      $this->configVO->getBaseUrl() . 'app',
      $parameters
    );
    return $response;
  }

  public function generateAuthLink() {
    // @todo implement
  }

  public function  getAccessTokenFromAuthCode() {
    // @todo implement
  }

}
