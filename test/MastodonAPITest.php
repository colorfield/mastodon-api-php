<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Assert;
use Dotenv\Dotenv;
use Colorfield\Mastodon\OAuthScope;
use Colorfield\Mastodon\MastodonOAuth;
use Colorfield\Mastodon\MastodonAPI;

/**
 * Class MastodonAPITest
 *
 * Contains the integration tests.
 */
final class MastodonAPITest extends TestCase
{

    /**
     * @var MastodonOAuth
     */
    protected $oAuth;

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

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->oAuth->config->setClientId($_ENV['CLIENT_ID']);
        $this->oAuth->config->setClientSecret($_ENV['CLIENT_SECRET']);
        $this->oAuth->config->setBearer($_ENV['BEARER']);
        $this->api = new Colorfield\Mastodon\MastodonAPI($this->oAuth->config);
    }

    public function testOAuthDefaultAuthorizationUrl()
    {
        $authorizationUrl = $this->oAuth->getAuthorizationUrl();
        Assert::assertTrue(str_starts_with($authorizationUrl, 'https://mastodon.social/oauth/authorize/?response_type=code&redirect_uri=urn%3Aietf%3Awg%3Aoauth%3A2.0%3Aoob&scope=read+write&client_id='));
    }

    public function testApiVerifyCredentials()
    {
        $credentials = $this->api->get('/accounts/verify_credentials');
        $user = new Colorfield\Mastodon\UserVO($credentials);
        $hasUserName = !empty($user->username);
        $hasUserId = !empty($user->id);
        Assert::assertTrue($hasUserName && $hasUserId);
    }

    public function testApiFollowers()
    {
        $credentials = $this->api->get('/accounts/verify_credentials');
        $user = new Colorfield\Mastodon\UserVO($credentials);
        $followers = $this->api->get('/accounts/' . $user->id . '/followers');
        Assert::assertTrue(is_array($followers));
    }

}
