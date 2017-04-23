<?php

use Colorfield\Mastodon\MastodonAPI;

/**
 * Class MastodonAPITest
 *
 * Contains the integration tests
 */
class MastodonAPITest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MastodonAPI
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $config = [
          'instance' => 'https://mstdn.archi',
        ];
        // @todo set configuration
        $this->api = new MastodonAPI($config);
    }

}
