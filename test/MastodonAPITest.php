<?php

/**
 * Class MastodonAPITest
 *
 * Contains the integration tests
 */
class MastodonAPITest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \MastodonAPI
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $config = new ConfigurationVO();
        // @todo set configuration
        $this->api = new \MastodonAPI($config);
    }

}
