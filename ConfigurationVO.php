<?php

/**
 * Class Configuration Value Object.
 */
class ConfigurationVO {

  /**
   * @var string
   */
  private $instanceName;

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

}
