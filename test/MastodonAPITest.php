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
        // @todo update with ConfigVO
        $config = [
          'instance' => 'https://mstdn.archi',
          'client_id' => '',
          'client_secret' => '',
          'redirect_uri' => '',
          'scopes' => 'read write follow',
          'website' => 'https://colorfield.be',
        ];

        $this->api = new MastodonAPI($config);
    }

}
