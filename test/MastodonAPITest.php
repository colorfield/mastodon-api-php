<?php

use Colorfield\Mastodon\MastodonAPI;
use Colorfield\Mastodon\MastodonOAuth;

/**
 * Class MastodonAPITest
 *
 * Contains the integration tests.
 */
class MastodonAPITest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Colorfield\Mastodon\MastodonAPI;
     */
    protected $api;

    /**
     * @var \Colorfield\Mastodon\MastodonOAuth
     */
    protected $oAuth;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        $name = 'MyMastodonApp';
        $instance = 'mastodon.social';
        $this->oAuth = new MastodonOAuth($name, $instance);
    }

    // @todo test oAuth
    // @todo test Mastodon API

    public function testAuthorizationUrl()
    {
        $authorizationUrl = $this->oAuth->getAuthorizationUrl();
        // @todo improve test
        $this->assertNotEmpty($authorizationUrl);
    }
}
