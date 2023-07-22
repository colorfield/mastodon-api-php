<?php

namespace Colorfield\Mastodon;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Exception;
use GuzzleHttp\Client;

/**
 * MastodonAPI
 *
 * @category Third party
 * @package  Mastodon-API-PHP
 * @author   Christophe Jossart <christophe@colorfield.eu>
 * @license  Apache License 2.0
 * @version  Release: <0.1.3>
 * @link     https://github.com/colorfield/mastodon-api-php
 */
class MastodonAPI
{
    // @todo improve return type for the api response

    /**
     * Class Constructor.
     *
     * @param ConfigurationVO $config The configuration value object.
     * @param ClientInterface $client The client interface. Optional, defaults to new Client().
     */
    public function __construct(
        public ConfigurationVO $config,
        public ClientInterface $client = new Client()
    ) {
    }

    /**
     * Sends a request to the specified API endpoint and returns the response.
     *
     * @param string $endpoint
     *   The API endpoint to send the request to.
     * @param string $method
     *   The HTTP method to use for the request ('get' or 'post').
     * @param array $json
     *   An array of data to send with the request in JSON format.
     * @param bool $authenticate
     *   Use OAuth. Defaults to true.
     *
     * @return mixed
     *   The response body from the API endpoint, or null if there was an error.
     * @throws GuzzleException|InvalidArgumentException|Exception
     */
    private function getResponse(string $endpoint, string $method, array $json, bool $authenticate = true): mixed
    {
        $uri = $this->config->getBaseUrl() . '/api/';
        $uri .= ConfigurationVO::API_VERSION . $endpoint;

        $allowedMethods = array_column(HttpOperation::cases(), 'name');
        if (!in_array($method, $allowedMethods)) {
            throw new InvalidArgumentException('ERROR: only ' . implode(',', $allowedMethods) . 'are allowed');
        }

        $options = [];
        if ($authenticate) {
            $options['headers'] = [
                'Authorization' => 'Bearer ' . $this->config->getBearer(),
            ];
        }
        $options['json'] = $json;

        $response = $this->client->request($method, $uri, $options);

        if ($response->getStatusCode() == '200') {
            $result = json_decode($response->getBody(), true);
        } else {
            throw new Exception('ERROR ' . $response->getStatusCode() . ': ' . $response->getReasonPhrase());
        }

        return $result;
    }

    /**
     * Get method.
     *
     * @param string $endpoint
     * @param array $params
     * @param bool $authenticate
     *    Use OAuth. Defaults to true, mostly for BC.
     *
     * @return mixed
     * @throws GuzzleException|Exception
     */
    public function get(string $endpoint, array $params = [], bool $authenticate = true): mixed
    {
        return $this->getResponse($endpoint, 'GET', $params, $authenticate);
    }

    /**
     * Get method, without authentication.
     *
     * Simplify public requests
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return mixed
     * @throws GuzzleException|Exception
     */
    public function getPublicData(string $endpoint, array $params = []): mixed
    {
        return $this->getResponse($endpoint, 'GET', $params, false);
    }

    /**
     * Post method.
     *
     * @param string $endpoint
     * @param array $params
     * @return mixed
     * @throws GuzzleException|Exception
     */
    public function post(string $endpoint, array $params = []): mixed
    {
        return $this->getResponse($endpoint, 'POST', $params);
    }

    /**
     * PUT method.
     *
     * @param string $endpoint
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function put(string $endpoint, array $params = []): mixed
    {
        throw new Exception('PUT method is not implemented yet.');
    }

    /**
     * PATCH method.
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return mixed
     * @throws Exception
     */
    public function patch(string $endpoint, array $params = []): mixed
    {
        throw new Exception('PATCH method is not implemented yet.');
    }

    /**
     * DELETE method.
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return mixed
     * @throws Exception
     */
    public function delete(string $endpoint, array $params = []): mixed
    {
        throw new Exception('DELETE method is not implemented yet.');
    }

    /**
     * Stream "method".
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return mixed
     * @throws Exception
     */
    public function stream(string $endpoint, array $params = []): mixed
    {
        // @todo stream is not a regular http method
        //   so it should be handled differently
        // https://docs.joinmastodon.org/methods/streaming/
        throw new Exception('Stream operation is not implemented yet.');
    }

}
