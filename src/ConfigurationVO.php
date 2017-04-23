<?php

namespace Colorfield\Mastodon;

/**
 * Class Configuration Value Object.
 */
class ConfigurationVO {

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
   * @var string
   */
  private $instanceName;

  public function __construct($config) {

    if(is_null($config['instance_name'])) {
      $this->setInstanceName(self::DEFAULT_INSTANCE_NAME);
    }else {
      $this->setInstanceName($config['instance_name']);
    }

    $this->baseUrl = $this->getInstanceName() . self::API_VERSION;
  }

  /**
   * @return string
   */
  public function getInstanceName() {
    return $this->instanceName;
  }

  /**
   * @param string $instanceName
   */
  public function setInstanceName($instanceName) {
    $this->instanceName = $instanceName;
  }

  public function getBaseUrl() {
    $this->getBaseUrl();
  }

}
