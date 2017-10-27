<?php

namespace Colorfield\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;

/**
 * Class MastodonOAuth.
 *
 * Usage: @todo
 */
class MastodonOAuth {

  /**
   * @var \Colorfield\Mastodon\ConfigurationVO
   */
  public $config;

  /**
   * @var \GuzzleHttp\ClientInterface
   */
  private $client;

  /**
   * Creates the OAuth object from the configuration.
   */
  public function __construct($client_name = ConfigurationVO::DEFAULT_NAME,
                              $mastodon_instance = ConfigurationVO::DEFAULT_INSTANCE) {
    $this->config = new ConfigurationVO($client_name, $mastodon_instance);

    /** @var \GuzzleHttp\Client client */
    $this->client = new Client();
  }

  /**
   * Get response from the API.
   *
   * @param $endpoint
   * @param array $json
   *
   * @return mixed|null
   */
  private function getResponse($endpoint, array $json) {
    $result = null;
    // endpoint
    $uri = $this->config->getBaseUrl() . $endpoint;
    try {
      $response = $this->client->post($uri, [
        'json' => $json,
      ]);
      // @todo $request->getHeader('content-type')
      if($response->getStatusCode() == '200') {
        $result = json_decode($response->getBody(), true);
      }else{
        echo 'ERROR: Status code ' . $response->getStatusCode();
      }
      // @todo check thrown exception
    } catch (\Exception $exception) {
      echo 'ERROR: ' . $exception->getMessage();
    }
    return $result;
  }

  /**
   * Register the Mastodon application.
   *
   * Appends client_id and client_secret tp the configuration value object.
   */
  public function registerApplication() {
    $options = $this->config->getAppConfig();
    $credentials = $this->getResponse('/apps', $options);
    if (isset($credentials["client_id"])
      && isset($credentials["client_secret"])) {
      $this->config->setClientId($credentials['client_id']);
      $this->config->setClientSecret($credentials['client_secret']);
    }else {
      echo 'ERROR: no credentials in API response';
    }
  }

  /**
   * Returns the authorization URL that will provide the authorization code"
   * after manual approval.
   *
   * @return string
   */
  public function getAuthorizationUrl() {
    $result = NULL;
    if (!$this->config->hasCredentials()) {
      $this->registerApplication();
    }
    //Return the Authorization URL
    return "https://{$this->config->getMastodonInstance()}/oauth/authorize/?".http_build_query([
        "response_type"    => "code",
        // @todo review usage of singular / plural in redirect_uri
        "redirect_uri"     => $this->config->getRedirectUris(),
        "scope"            => $this->config->getScopes(),
        "client_id"        => $this->config->getClientId(),
      ]);
  }

  /**
   *@todo description
   */
  public function getAccessTokenFromAuthCode() {
    $result = NULL;
    $uri = $this->config->getBaseUrl() . '/oauth/token';
    return $result;
  }

  /**
   * @todo description
   *
   * @return string
   */
  public function getBearer($token) {
    $result = NULL;
    // @todo implement
    return $result;
  }

  /**
   * @todo description
   *
   * @param $token
   */
  public function authenticate($token) {
    if (empty($this->config->getBearer())) {
      $this->getBearer($token);
    }
    else {
      // @todo
    }
  }

}
