<?php

namespace Colorfield\Mastodon;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use Exception;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

/**
 * MastodonAPI
 *
 * @category Third party
 * @package  Mastodon-API-PHP
 * @author   Christophe Jossart <christophe@colorfield.eu>
 * @license  Apache License 2.0
 * @version  Release: <0.1.2>
 * @link     https://github.com/colorfield/mastodon-api-php
 */
class MastodonAPI
{
    // @todo improve return type for the api response

    /**
     * Creates the API object.
     *
     * @param ConfigurationVO $config
     */
    public function __construct(
        public ConfigurationVO $config,
        public ClientInterface $client = new Client()
    ) { }

    /**
     * Sends a request to the specified API endpoint and returns the response.
     *
     * @param string $endpoint
     *   The API endpoint to send the request to.
     * @param string $method
     *   The HTTP method to use for the request ('get' or 'post').
     * @param array $json
     *   An array of data to send with the request in JSON format.
     *
     * @return mixed
     *   The response body from the API endpoint, or null if there was an error.
     * @throws GuzzleException|InvalidArgumentException|Exception
     */
    private function getResponse(string $endpoint, string $method, array $json): mixed
    {
        $uri = $this->config->getBaseUrl() . '/api/';
        $uri .= ConfigurationVO::API_VERSION . $endpoint;

        $allowedMethods = array_column(HttpOperation::cases(), 'name');
        if (!in_array($method, $allowedMethods)) {
            throw new InvalidArgumentException('ERROR: only ' . implode(',', $allowedMethods) . 'are allowed');
        }

        $response = $this->client->request($method, $uri, [
            'headers' => [
              'Authorization' => 'Bearer ' . $this->config->getBearer(),
            ],
            'json' => $json,
        ]);

        if ($response instanceof ResponseInterface
          && $response->getStatusCode() == '200') {
            $result = json_decode($response->getBody(), true);
        } else {
           throw new Exception('ERROR ' . $response->getStatusCode() . ' : ' . $response->getReasonPhrase());
        }
        return $result;
    }

    /**
     * Get method.
     *
     * @param string $endpoint
     * @param array $params
     *
     * @return mixed
     */
    public function get(string $endpoint, array $params = []): mixed
    {
        return $this->getResponse($endpoint, 'GET', $params);
    }

    /**
     * Post method.
     *
     * @param string $endpoint
     * @param array $params
     * @return mixed
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
     * @return mixed
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
     */
    public function stream(string $endpoint, array $params = []): mixed
    {
        // @todo stream is not a regular http method
        //   so it should be handled differently
        // https://docs.joinmastodon.org/methods/streaming/
        throw new Exception('Stream operation is not implemented yet.');
    }

}
