<?php

namespace Colorfield\Mastodon;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class MastodonOAuth.
 *
 * Usage: @todo
 */
class MastodonOAuth
{

    public ConfigurationVO $config;

    private ClientInterface $client;

    /**
     * Creates the OAuth object from the configuration.
     */
    public function __construct($client_name = ConfigurationVO::DEFAULT_NAME,
        $mastodon_instance = ConfigurationVO::DEFAULT_INSTANCE
    ) {
        // @todo use promoted properties
        $this->config = new ConfigurationVO($client_name, $mastodon_instance);
        $this->client = new Client();
    }

    /**
     * Get response from the endpoint.
     *
     * @param string $endpoint
     * @param array $json
     *
     * @return mixed
     */
    private function getResponse(string $endpoint, array $json): mixed
    {
        $result = null;
        // endpoint
        $uri = $this->config->getBaseUrl() . $endpoint;
        try {
            $response = $this->client->post(
                $uri, [
                    'json' => $json,
                ]
            );
            // @todo $request->getHeader('content-type')
            if ($response->getStatusCode() == '200') {
                $result = json_decode($response->getBody(), true);
            } else {
                echo 'ERROR: Status code ' . $response->getStatusCode();
            }
            // @todo check thrown exception
        } catch (Exception $exception) {
            echo 'ERROR: ' . $exception->getMessage();
        }
        return $result;
    }

    /**
     * Register the Mastodon application.
     *
     * Appends client_id and client_secret to the configuration value object.
     *
     * @return void
     */
    public function registerApplication(): void
    {
        $options = $this->config->getAppConfiguration();
        $credentials = $this->getResponse(
            '/api/'.ConfigurationVO::API_VERSION.'/apps',
            $options
        );
        if (isset($credentials["client_id"])
            && isset($credentials["client_secret"])
        ) {
            $this->config->setClientId($credentials['client_id']);
            $this->config->setClientSecret($credentials['client_secret']);
        } else {
            echo 'ERROR: no credentials in API response';
        }
    }

    /**
     * Returns the authorization URL that will provide the authorization code"
     * after manual approval.
     *
     * @return string
     */
    public function getAuthorizationUrl(): string
    {
        if (!$this->config->hasCredentials()) {
            $this->registerApplication();
        }
        return "https://{$this->config->getMastodonInstance()}/oauth/authorize/?".http_build_query(
            [
                "response_type"    => "code",
                // @todo review usage of singular / plural in redirect_uri
                "redirect_uri"     => $this->config->getRedirectUris(),
                "scope"            => $this->config->getScopes(),
                "client_id"        => $this->config->getClientId(),
            ]
        );
    }

    /**
     * Gets the access token.
     * As a side effect, stores it into the Configuration as bearer.
     *
     * @todo fix name and side effect, we expect a return value here
     */
    public function getAccessToken(): void
    {
        $options = $this->config->getAccessTokenConfiguration();
        $token = $this->getResponse('/oauth/token', $options);
        if (isset($token['access_token'])) {
            $this->config->setBearer($token['access_token']);
        }else {
            echo 'ERROR: no access token in API response';
        }
    }

    /**
     * Authenticates a user.
     *
     * @param string $email
     * @param string $password
     *
     * @return array
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
