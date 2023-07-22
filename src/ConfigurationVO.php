<?php

namespace Colorfield\Mastodon;

use InvalidArgumentException;

/**
 * Class Configuration Value Object.
 *
 * Configuration used by the MastodonOAuth and MastodonAPI classes.
 */
class ConfigurationVO
{
    /**
     * Default instance domain, without the protocol.
     *
     * @var string
     */
    public const DEFAULT_INSTANCE = 'mastodon.social';

    /**
     * Application default name
     *
     * @var string
     */
    public const DEFAULT_NAME = 'MastodonAPIPHP';

    /**
     * Mastodon API version.
     *
     * @var string
     */
    public const API_VERSION = 'v1';

    /**
     * Default URI.
     *
     * @var string
     */
    public const DEFAULT_REDIRECT_URIS = 'urn:ietf:wg:oauth:2.0:oob';

    /**
     * Default website.
     *
     * @var string
     */
    public const DEFAULT_WEBSITE = 'https://colorfield.dev';

    /**
     * Base URL.
     *
     * Example: https://mastodon.social
     *
     * @var string
     */
    private string $baseUrl;

    /**
     * Client ID obtained during the authentication phase.
     *
     * @var string
     */
    private string $clientId;

    /**
     * Client secret obtained during the authentication phase.
     *
     * @var string
     */
    private string $clientSecret;

    /**
     * Client bearer obtained during the authentication phase.
     *
     * @var string
     */
    private string $bearer;

    /**
     * Authorization code obtained during the authentication phase.
     *
     * @var string
     */
    private string $authorizationCode;

    /**
     * Class constructor for initializing the API client.
     *
     * @param string $clientName The name of the client (optional, default: self::DEFAULT_NAME).
     * @param string $mastodonInstance The URL of the Mastodon instance (optional, default: self::DEFAULT_INSTANCE).
     * @param string $redirectUris The redirect URIs for authentication (optional, default: self::DEFAULT_REDIRECT_URIS).
     * @param string $apiVersion The version of the Mastodon API (optional, default: self::API_VERSION).
     * @param string $website The website URL of the client (optional, default: self::DEFAULT_WEBSITE).
     * @param array $scopes The required scopes for the client (optional, default: empty array).
     *     Will be set to ['read', 'write'] if empty.
     *
     * @return void
     */
    public function __construct(
        public string $clientName = self::DEFAULT_NAME,
        public string $mastodonInstance = self::DEFAULT_INSTANCE,
        public string $redirectUris = self::DEFAULT_REDIRECT_URIS,
        public string $apiVersion = self::API_VERSION,
        public string $website = self::DEFAULT_WEBSITE,
        public array $scopes = [],
    ) {
        // Move as promoted property when removing PHP 8.1 support.
        if (empty($this->scopes)) {
            $this->setScopes([OAuthScope::read->name, OAuthScope::write->name]);
        }
        $this->setBaseUrl();
    }

    /**
     * Checks if the credentials are already defined.
     *
     * @return bool
     */
    public function hasCredentials(): bool
    {
        return !empty($this->clientId) && !empty($this->clientSecret);
    }

    /**
     * Returns the app configuration to be used to
     * get the app authorization credentials (client_id and client_secret).
     *
     * @return array
     */
    public function getAppConfiguration(): array
    {
        return [
            'client_name'   => $this->getClientName(),
            'redirect_uris' => $this->getRedirectUris(),
            'scopes'        => $this->getScopes(),
            'website'       => $this->getWebsite(),
        ];
    }

    /**
     * Returns the OAuth token configuration to be used to
     * get the bearer.
     *
     * @return array
     */
    public function getAccessTokenConfiguration(): array
    {
        return [
            'grant_type'    => 'authorization_code',
            'redirect_uris' => $this->getRedirectUris(),
            'client_id'     => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'code'          => $this->getAuthorizationCode(),
        ];
    }

    /**
     * Returns the user authentication configuration.
     *
     * @param string $email
     * @param string $password
     *
     * @return array
     */
    public function getUserAuthenticationConfiguration(string $email, string $password): array
    {
        return [
            'grant_type'    => 'password',
            'client_id'     => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'username'      => $email,
            'password'      => $password,
            'scope'         => $this->getScopes(),
        ];
    }

    /**
     * Returns the OAuth scopes.
     *
     * @fixme  setting an array and getting a string is counterintuitive
     *
     * @return string
     */
    public function getScopes(): string
    {
        return implode(' ', $this->scopes);
    }

    /**
     * Sets the OAuth scopes.
     *
     * @param array $scopes
     */
    public function setScopes(array $scopes): void
    {
        // Mastodon defaults itself to read if no scope configured.
        if (!empty($scopes)) {
            $scopeValues = array_column(OAuthScope::cases(), 'name');
            // Check scope values.
            if (count(array_intersect($scopes, $scopeValues)) === count($scopes)) {
                $this->scopes = $scopes;
            } else {
                throw new InvalidArgumentException('Wrong scopes defined, expected one or many from read write follow push. See README.');
            }
        }
    }

    /**
     * Returns the Mastodon instance base url.
     *
     * With the protocol. Example: https://mastodon.social
     *
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Sets the Mastodon instance base url.
     */
    private function setBaseUrl(): void
    {
        $result = "https://{$this->getMastodonInstance()}";
        $this->baseUrl = $result;
    }

    /**
     * Returns the Mastodon instance domain.
     *
     * @return string
     */
    public function getMastodonInstance(): string
    {
        return $this->mastodonInstance;
    }

    /**
     * Sets the Mastodon instance domain.
     *
     * Without the protocol. Example: mastodon.social
     *
     * @param string $instance
     */
    public function setMastodonInstance(string $instance): void
    {
        $this->mastodonInstance = $instance;
    }

    /**
     * Returns the client application name.
     *
     * @return string
     */
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * Sets the client application name.
     *
     * @param string $clientName
     */
    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    /**
     * Returns the client application website.
     *
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
     * Sets the client application website.
     *
     * @param string $website
     */
    public function setWebsite(string $website): void
    {
        if (!empty($website)) {
            // @todo validation
            $this->website = $website;
        }
    }

    /**
     * Returns the OAuth client id.
     *
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Sets the OAuth client id.
     *
     * @param string $clientId
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * Returns the OAuth client secret.
     *
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Sets the OAuth client secret.
     *
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * Returns the OAuth authorization code.
     *
     * @return string
     */
    public function getAuthorizationCode(): string
    {
        return $this->authorizationCode;
    }

    /**
     * Sets the OAuth authorization code.
     *
     * @param string $code
     */
    public function setAuthorizationCode(string $code): void
    {
        $this->authorizationCode = $code;
    }

    /**
     * Returns the OAuth bearer token.
     *
     * @return string
     */
    public function getBearer(): string
    {
        return $this->bearer;
    }

    /**
     * Sets the OAuth bearer token.
     *
     * @param string $bearer
     */
    public function setBearer(string $bearer): void
    {
        $this->bearer = $bearer;
    }

    /**
     * Returns the OAuth redirect uris.
     *
     * @return string
     */
    public function getRedirectUris(): string
    {
        return $this->redirectUris;
    }

    /**
     * Sets the OAuth redirect uris.
     *
     * @param string $redirectUris
     */
    public function setRedirectUris(string $redirectUris): void
    {
        $this->redirectUris = $redirectUris;
    }

}
