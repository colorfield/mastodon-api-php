<?php

use Colorfield\Mastodon\MastodonAPI;
use Colorfield\Mastodon\ConfigurationVO;
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
        $config = new ConfigurationVO($name, $instance);
        $this->api = new MastodonAPI($config);
    }

    public function testApiPublicTimeline()
    {
        $timeline = $this->api->get('/timelines/public', [], false);
        Assert::assertTrue(is_array($timeline));

        $timeline = $this->api->getPublicData('/timelines/public');
        Assert::assertTrue(is_array($timeline));
    }

}
