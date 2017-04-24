<?php

namespace Colorfield\Mastodon;

/**
 * Class Configuration Value Object.
 */
class ConfigurationVO {

  /**
   * @var string
   */
  const DEFAULT_INSTANCE = 'https://mastodon.social';

  /**
   * @var string
   */
  const API_VERSION = '/api/v1/';

  /**
   * @var string
   */
  const DEFAULT_REDIRECT_URI = 'urn:ietf:wg:oauth:2.0:oob';

  /**
   * @var string
   */
  const DEFAULT_TIME_OUT = 300;

  /**
   * @var string
   */
  const SCOPE_READ = 'read';

  /**
   * @var string
   */
  const SCOPE_WRITE = 'write';

  /**
   * @var string
   */
  const SCOPE_FOLLOW = 'follow';

  /**
   * @var string
   */
  private $baseUrl;

  /**
   * @var string
   */
  private $mastodonInstance;

  /**
   * @var string
   */
  private $clientId;

  /**
   * @var string
   */
  private $clientSecret;

  /**
   * @var $string
   */
  private $redirectUri;

  /**
   * @var $string
   */
  private $website;

  /**
   * @var array
   */
  private $token;

  /**
   * @var array
   */
  private $scopes;

  /**
   * Creates the Configuration Value Object.
   *
   * @throws \InvalidArgumentException
   * @param array $config
   */
  public function __construct(array $config) {

    // Throw exeception for mandatory params
    if (!isset ($config['client_id'])) {
      throw new \InvalidArgumentException('Incomplete configuration, see README.');
    }

    // Default to the main instance if no instance configured.
    $instance = empty ($config['instance_name']) ? self::DEFAULT_INSTANCE : $config['instance'];
    $this->setMastodonInstance($instance);
    $this->baseUrl = $this->getMastodonInstance() . self::API_VERSION;

    // Default website to empty if not set.
    $website = isset ($config['website']) ? '' : $config['website'];
    $this->website = $website;

    // Mastodon defaults itself to read if no scope configured.
    if (!empty ($config['scopes'])) {
      $scopeValues = [self::SCOPE_READ, self::SCOPE_WRITE, self::SCOPE_FOLLOW];
      $configuredScopes = explode(' ', $config);
      // Check scope values
      if (count(array_intersect($configuredScopes, $scopeValues)) == count($configuredScopes)) {
        $this->scopes = $config['scopes'];
      }
      else {
        throw new \InvalidArgumentException('Wrong scopes defined, expected one ore many from read write follow. See README.');
      }
    }

  }

  /**
   * @return string
   */
  public function getBaseUrl() {
    return $this->getBaseUrl();
  }

  /**
   * @return string
   */
  public function getMastodonInstance() {
    return $this->mastodonInstance;
  }

  /**
   * @param string $instanceName
   */
  public function setMastodonInstance($instance) {
    $this->mastodonInstance = $instance;
  }

  /**
   * @return string
   */
  public function getClientId() {
    return $this->clientId;
  }

  /**
   * @param string $clientId
   */
  public function setClientId($clientId) {
    $this->clientId = $clientId;
  }

  /**
   * @return string
   */
  public function getClientSecret() {
    return $this->clientSecret;
  }

  /**
   * @param string $clientSecret
   */
  public function setClientSecret($clientSecret) {
    $this->clientSecret = $clientSecret;
  }

  /**
   * @return mixed
   */
  public function getRedirectUri() {
    return $this->redirectUri;
  }

  /**
   * @param mixed $redirectUri
   */
  public function setRedirectUri($redirectUri) {
    $this->redirectUri = $redirectUri;
  }

  /**
   * @return mixed
   */
  public function getWebsite() {
    return $this->website;
  }

  /**
   * @param mixed $website
   */
  public function setWebsite($website) {
    $this->website = $website;
  }

  /**
   * @return array
   */
  public function getToken() {
    return $this->token;
  }

  /**
   * @param array $token
   */
  public function setToken($token) {
    $this->token = $token;
  }

  /**
   * @return array
   */
  public function getScopes() {
    return $this->scopes;
  }

  /**
   * @param array $scopes
   */
  public function setScopes($scopes) {
    $this->scopes = $scopes;
  }

}
