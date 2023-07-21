<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Colorfield\Mastodon\MastodonAPI;
use Colorfield\Mastodon\MastodonOAuth;
use Colorfield\Mastodon\Scope;

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

    // @todo test OAuth
    // @todo test Mastodon API

    public function testDefaultAuthorizationUrl()
    {
        $authorizationUrl = $this->oAuth->getAuthorizationUrl();
        Assert::assertTrue(str_starts_with($authorizationUrl, 'https://mastodon.social/oauth/authorize/?response_type=code&redirect_uri=urn%3Aietf%3Awg%3Aoauth%3A2.0%3Aoob&scope=read+write&client_id='));
    }

}
