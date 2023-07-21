<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Colorfield\Mastodon\MastodonAPI;
use Colorfield\Mastodon\MastodonOAuth;

/**
 * Class MastodonAPITest
 *
 * Contains the integration tests.
 */
final class MastodonAPITest extends TestCase
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
    public function setUp(): void
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
        Assert::assertNotEmpty($authorizationUrl);
    }
}
