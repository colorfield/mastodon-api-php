<?php

use Colorfield\Mastodon\MastodonAPI;
use Colorfield\Mastodon\MastodonOAuth;
use Dotenv\Dotenv;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * Class MastodonApiPublic
 *
 * Contains the integration tests for API calls that do not require authentication.
 */
final class MastodonApiPublic extends TestCase
{

    /**
     * @var MastodonAPI;
     */
    protected $api;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        $name = 'MyMastodonApp';
        $instance = 'mastodon.social';
        $this->oAuth = new MastodonOAuth($name, $instance);
    }

    public function testApiPublicTimeline()
    {
        $this->api = new MastodonAPI($this->oAuth->config);
        $timeline = $this->api->get('/timelines/public');
        Assert::assertTrue(is_array($timeline));
    }

}
