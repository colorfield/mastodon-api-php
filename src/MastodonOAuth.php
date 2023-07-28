<?php

namespace Colorfield\Mastodon;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Class MastodonOAuth.
 *
 * Usage: see README.md
 */
class MastodonOAuth
{
    public ConfigurationVO $config;

    private readonly ClientInterface $client;

    /**
     * Creates the OAuth object from the configuration.
     */
    public function __construct(
        $client_name = ConfigurationVO::DEFAULT_NAME,
        $mastodon_instance = ConfigurationVO::DEFAULT_INSTANCE
    ) {
        $this->config = new ConfigurationVO($client_name, $mastodon_instance);
        $this->client = new Client();
    }

    /**
     * Get response from the endpoint.
     *
     *
     * @return mixed
     * @throws GuzzleException|Exception
     */
    private function getResponse(string $endpoint, array $json): mixed
    {
        // endpoint
        $uri = $this->config->getBaseUrl() . $endpoint;
        $response = $this->client->post(
            $uri,
            [
                'json' => $json,
            ]
        );
        // @todo $request->getHeader('content-type')
        if ($response->getStatusCode() == '200') {
            $result = json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } else {
            throw new Exception('ERROR ' . $response->getStatusCode() . ' : ' . $response->getReasonPhrase());
        }
        return $result;
    }

    /**
     * Register the Mastodon application.
     *
     * Appends client_id and client_secret to the configuration value object.
     *
     * @return void
     * @throws GuzzleException|Exception
     */
    public function registerApplication(): void
    {
        $options = $this->config->getAppConfiguration();
        $credentials = $this->getResponse(
            '/api/' . ConfigurationVO::API_VERSION . '/apps',
            $options
        );
        if (isset($credentials['client_id'])
            && isset($credentials['client_secret'])
        ) {
            $this->config->setClientId($credentials['client_id']);
            $this->config->setClientSecret($credentials['client_secret']);
        } else {
            throw new Exception('ERROR: no credentials in API response');
        }
    }

    /**
     * Returns the authorization URL that will provide the authorization code"
     * after manual approval.
     *
     * @return string
     * @throws GuzzleException|Exception
     */
    public function getAuthorizationUrl(): string
    {
        if (!$this->config->hasCredentials()) {
            $this->registerApplication();
        }
        return "https://{$this->config->getMastodonInstance()}/oauth/authorize/?".http_build_query(
            [
                'response_type'    => 'code',
                // @todo review usage of singular / plural in redirect_uri
                //   singular seems to be required here.
                'redirect_uri'     => $this->config->getRedirectUris(),
                'scope'            => $this->config->getScopes(),
                'client_id'        => $this->config->getClientId(),
            ]
        );
    }

    /**
     * Gets the access token.
     *
     * As a side effect, stores it into the Configuration as bearer.
     *
     * @return string
     * @throws GuzzleException|Exception
     */
    public function getAccessToken(): string
    {
        $options = $this->config->getAccessTokenConfiguration();
        // @todo fix workaround for plural / singular.
        $options['redirect_uri'] = $options['redirect_uris'];
        $token = $this->getResponse('/oauth/token', $options);
        if (isset($token['access_token'])) {
            $this->config->setBearer($token['access_token']);
        } else {
            throw new Exception('ERROR: no access token in API response');
        }
        return $token['access_token'];
    }

    /**
     * Authenticates a user.
     *
     *
     * @return array
     * @throws GuzzleException|Exception
     */
    public function authenticateUser(string $email, string $password): array
    {
        if (empty($this->config->getBearer())) {
            $this->getAccessToken();
        }
        // @todo validate email address and password
        $options = $this->config->getUserAuthenticationConfiguration(
            $email,
            $password
        );
        // @todo test, returns the bearer if success
        $token = $this->getResponse('/oauth/token', $options);
        $this->config->setBearer($token['access_token']);
        return $token;
    }

}
