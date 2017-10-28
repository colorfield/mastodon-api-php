<?php

namespace Colorfield\Mastodon;

/**
 * Class Configuration Value Object.
 *
 * Configuration used by the MastodonOAuth and MastodonAPI classes.
 * @todo validate each setter
 */
class ConfigurationVO {

  /**
   * @var string
   */
  const DEFAULT_INSTANCE = 'mastodon.social';

  /**
   * @var string
   */
  const DEFAULT_NAME = 'MastodonAPIPHP';

  /**
   * @var string
   */
  const API_VERSION = 'v1';

  /**
   * @var string
   */
  const DEFAULT_REDIRECT_URIS = 'urn:ietf:wg:oauth:2.0:oob';

  /**
   * @var string
   */
  const DEFAULT_WEBSITE = 'https://colorfield.be';

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
  private $clientName;

  /**
   * @var string
   */
  private $clientId;

  /**
   * @var string
   */
  private $clientSecret;

  /**
   * @var string
   */
  private $bearer;

  /**
   * @var $string
   */
  private $redirectUris;

  /**
   * @var $string
   */
  private $website;

  /**
   * @var array
   */
  private $authorizationCode;

  /**
   * @var array
   */
  private $scopes;


  /**
   * ConfigurationVO constructor.
   *
   * @param string $client_name
   * @param string $mastodon_instance
   */
  public function __construct($client_name = self::DEFAULT_NAME, $mastodon_instance = self::DEFAULT_INSTANCE) {
    $this->setClientName($client_name);
    $this->setMastodonInstance($mastodon_instance);
    $this->setRedirectUris(self::DEFAULT_REDIRECT_URIS);
    $this->setScopes(['read', 'write']);
    $this->setWebsite(self::DEFAULT_WEBSITE);
    $this->setBaseUrl();
  }

  /**
   * Initializes the Configuration Value Object with oAuth credentials
   *
   * To be used by the MastodonAPI class after authentication.
   * It should contain the client_id, client_secret and bearer.
   *
   * @throws \InvalidArgumentException
   * @param array $config
   */
  public function setOAuthCredentials(array $config) {
    // @todo change by using ConfigVO
    // Throw exeception for mandatory params
    if (!isset ($config['client_id'])) {
      throw new \InvalidArgumentException('Missing client_id.');
    }

    // Throw exeception for mandatory params
    if (!isset ($config['client_secret'])) {
      throw new \InvalidArgumentException('Missing client_secret.');
    }

    // Throw exeception for mandatory params
    if (!isset ($config['bearer'])) {
      throw new \InvalidArgumentException('Missing client_secret.');
    }
  }

  /**
   * Checks if the credentials are already defined.
   *
   * @return bool
   */
  public function hasCredentials() {
    return !empty($this->clientId) && !empty($this->clientSecret);
  }

  /**
   * Returns the app configuration to be used to
   * get the app authorization credentials (client_id and client_secret).
   *
   * @return array
   */
  public function getAppConfiguration() {
    return [
      'client_name'   => $this->getClientName(),
      'redirect_uris' => $this->getRedirectUris(),
      'scopes'        => $this->getScopes(),
      'website'       => $this->getWebsite(),
    ];
  }

  /**
   * Returns the oAuth token configuration to be used to
   * get the bearer.
   *
   * @return array
   */
  public function getAccessTokenConfiguration() {
    return [
      'grant_type'    => 'authorization_code',
      'redirect_uri'  => $this->getRedirectUris(),
      'client_id'     => $this->getClientId(),
      'client_secret' => $this->getClientSecret(),
      'code'          => $this->getAuthorizationCode(),
    ];
  }

  /**
   * Returns the user authentication configuration.
   *
   * @param $email
   * @param $password
   *
   * @return array
   */
  public function getUserAuthenticationConfiguration($email, $password) {
    return [
      'grant_type'    => 'password',
      'client_id'     => $this->getClientId(),
      'client_secret' => $this->getClientSecret(),
      'username'      => $email,
      'password'      => $password,
      'scope'         => $this->getScopes(),
    ];
  }

  /**
   * @return array
   */
  public function getScopes() {
    return implode(' ', $this->scopes);
  }

  /**
   * @param array $scopes
   */
  public function setScopes(array $scopes) {
    // @todo
    // Mastodon defaults itself to read if no scope configured.
    if (!empty ($scopes)) {
      $scopeValues = [self::SCOPE_READ, self::SCOPE_WRITE, self::SCOPE_FOLLOW];
      // Check scope values
      if (count(array_intersect($scopes, $scopeValues)) == count($scopes)) {
        $this->scopes = $scopes;
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
    return $this->baseUrl;
  }

  /**
   * Set the base url, enforces https.
   */
  private function setBaseUrl() {
    $result = "https://{$this->getMastodonInstance()}";
    $this->baseUrl = $result;
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
  public function getClientName() {
    return $this->clientName;
  }

  /**
   * @param string $clientName
   */
  public function setClientName($clientName) {
    $this->clientName = $clientName;
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
   * @return string
   */
  public function getBearer() {
    return $this->bearer;
  }

  /**
   * @param string $bearer
   */
  public function setBearer($bearer) {
    $this->bearer = $bearer;
  }

  /**
   * @return mixed
   */
  public function getRedirectUris() {
    return $this->redirectUris;
  }

  /**
   * @param mixed $redirectUri
   */
  public function setRedirectUris($redirectUris) {
    $this->redirectUris = $redirectUris;
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
    if(!empty($website)) {
      // @todo validation
      $this->website = $website;
    }
  }

  /**
   * @return array
   */
  public function getAuthorizationCode() {
    return $this->authorizationCode;
  }

  /**
   * @param array $token
   */
  public function setAuthorizationCode($code) {
    $this->authorizationCode = $code;
  }

}
