<?php

namespace Colorfield\Mastodon;

use InvalidArgumentException;

enum Scope
{
    case read;
    case write;
    case follow;
    case push;
}

/**
 * Class Configuration Value Object.
 *
 * Configuration used by the MastodonOAuth and MastodonAPI classes.
 *
 * @todo validate each setter
 */
class ConfigurationVO
{
    /**
     * Default instance domain, without the protocol.
     *
     * @var string
     */
    const DEFAULT_INSTANCE = 'mastodon.social';

    /**
     * Application default name
     *
     * @var string
     */
    const DEFAULT_NAME = 'MastodonAPIPHP';

    /**
     * Mastodon API version.
     *
     * @var string
     */
    const API_VERSION = 'v1';

    /**
     * Default URI.
     *
     * @var string
     */
    const DEFAULT_REDIRECT_URIS = 'urn:ietf:wg:oauth:2.0:oob';

    /**
     * Default website.
     *
     * @var string
     */
    const DEFAULT_WEBSITE = 'https://colorfield.dev';

    /**
     * Read scope.
     *
     * @var string
     */
    const SCOPE_READ = 'read';

    /**
     * Write scope.
     *
     * @var string
     */
    const SCOPE_WRITE = 'write';

    /**
     * Follow scope.
     *
     * @var string
     */
    const SCOPE_FOLLOW = 'follow';

    /**
     * Base URL.
     *
     * Example: https://mastodon.social
     *
     * @var string
     */
    private string $baseUrl;

    /**
     * Mastodon instance domain.
     *
     * Example: mastodon.social
     *
     * @var string
     */
    private string $mastodonInstance;

    /**
     * Client name.
     *
     * Example: MyMastodonApp.
     *
     * @var string
     */
    private string $clientName;

    /**
     * Client ID obtained during the auth phase.
     *
     * @var string
     */
    private string $clientId;

    /**
     * Client secret obtained during the auth phase.
     *
     * @var string
     */
    private string $clientSecret;

    /**
     * Client bearer obtained during the auth phase.
     *
     * @var string
     */
    private string $bearer;

    /**
     * Redirect URI.
     *
     * @fixme redirectUris is singular
     * @var   string
     */
    private string $redirectUris;

    /**
     * Website, with the protocol.
     *
     * @var string
     */
    private string $website;

    /**
     * Authorization code obtained during the auth phase.
     *
     * @var string
     */
    private string $authorizationCode;

    /**
     * Scopes. Possible values: read, write, follow.
     *
     * @var array
     */
    private array $scopes;

    /**
     * ConfigurationVO constructor.
     *
     * @todo define default timeout.
     *
     * @param string $client_name
     * @param string $mastodon_instance
     */
    public function __construct(string $client_name = self::DEFAULT_NAME, string $mastodon_instance = self::DEFAULT_INSTANCE)
    {
        $this->setClientName($client_name);
        $this->setMastodonInstance($mastodon_instance);
        $this->setRedirectUris(self::DEFAULT_REDIRECT_URIS);
        $this->setScopes(['read', 'write']);
        $this->setWebsite(self::DEFAULT_WEBSITE);
        $this->setBaseUrl();
    }

    /**
     * Initializes the Configuration Value Object with oAuth credentials
     *
     * To be used by the MastodonAPI class after authentication.
     * It should contain the client_id, client_secret and bearer.
     *
     * @throws InvalidArgumentException
     * @param  array $config
     */
    public function setOAuthCredentials(array $config): void
    {
        // @todo change by using ConfigVO
        // Throw exception for mandatory params
        if (!isset($config['client_id'])) {
            throw new InvalidArgumentException('Missing client_id.');
        }

        // Throw exeception for mandatory params
        if (!isset($config['client_secret'])) {
            throw new InvalidArgumentException('Missing client_secret.');
        }

        // Throw exeception for mandatory params
        if (!isset($config['bearer'])) {
            throw new InvalidArgumentException('Missing client_secret.');
        }
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
     * Returns the oAuth token configuration to be used to
     * get the bearer.
     *
     * @return array
     */
    public function getAccessTokenConfiguration(): array
    {
        return [
            'grant_type'    => 'authorization_code',
            'redirect_uri'  => $this->getRedirectUris(),
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
     * @fixme  setting an array and getting a string is counterintuitive
     * @return string
     */
    public function getScopes(): string
    {
        return implode(' ', $this->scopes);
    }

    /**
     * @param array $scopes
     */
    public function setScopes(array $scopes)
    {
        // Mastodon defaults itself to read if no scope configured.
        if (!empty($scopes)) {
            $scopeValues = array_column(Scope::cases(), 'name');
            // Check scope values.
            if (count(array_intersect($scopes, $scopeValues)) === count($scopes)) {
                $this->scopes = $scopes;
            } else {
                throw new InvalidArgumentException('Wrong scopes defined, expected one or many from read write follow push. See README.');
            }
        }
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * Sets the base url, enforces https.
     */
    private function setBaseUrl(): void
    {
        $result = "https://{$this->getMastodonInstance()}";
        $this->baseUrl = $result;
    }

    /**
     * @return string
     */
    public function getMastodonInstance(): string
    {
        return $this->mastodonInstance;
    }

    /**
     * @param string $instance
     */
    public function setMastodonInstance(string $instance): void
    {
        $this->mastodonInstance = $instance;
    }

    /**
     * @return string
     */
    public function getClientName(): string
    {
        return $this->clientName;
    }

    /**
     * @param string $clientName
     */
    public function setClientName(string $clientName): void
    {
        $this->clientName = $clientName;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getBearer(): string
    {
        return $this->bearer;
    }

    /**
     * @param string $bearer
     */
    public function setBearer(string $bearer): void
    {
        $this->bearer = $bearer;
    }

    /**
     * @return string
     */
    public function getRedirectUris(): string
    {
        return $this->redirectUris;
    }

    /**
     * @param string $redirectUris
     */
    public function setRedirectUris(string $redirectUris): void
    {
        $this->redirectUris = $redirectUris;
    }

    /**
     * @return string
     */
    public function getWebsite(): string
    {
        return $this->website;
    }

    /**
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
     * @return string
     */
    public function getAuthorizationCode(): string
    {
        return $this->authorizationCode;
    }

    /**
     * @param string $code
     */
    public function setAuthorizationCode(string $code): void
    {
        $this->authorizationCode = $code;
    }
}
