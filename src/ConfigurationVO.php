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
  private $instance;

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
    if (!isset ($config['client_id']) || !isset ($config['client_secret'])) {
      throw new \InvalidArgumentException('Incomplete configuration, see README.');
    }

    // Default to the main instance if no instance configured.
    $instance = empty ($config['instance_name']) ? self::DEFAULT_INSTANCE : $config['instance'];
    $this->setMastodonInstance($instance);
    $this->baseUrl = $this->getMastodonInstance() . self::API_VERSION;

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
  public function getMastodonInstance() {
    return $this->instance;
  }

  /**
   * @param string $instanceName
   */
  public function setMastodonInstance($instance) {
    $this->instanceName = $instance;
  }

  /**
   * @return string
   */
  public function getBaseUrl() {
    return $this->getBaseUrl();
  }

}
