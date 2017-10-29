<?php

namespace Colorfield\Mastodon;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * MastodonAPI
 *
 * PHP version >= 5.6.0
 *
 * @category Third party
 * @package  Mastodon-API-PHP
 * @author   Christophe Jossart <christophe@colorfield.eu>
 * @license  Apache License 2.0
 * @version  Release: <0.0.1>
 * @link     https://github.com/r-daneelolivaw/mastodon-api-php
 */
class MastodonAPI
{

    /**
     * @var \Colorfield\Mastodon\ConfigurationVO
     */
    private $config;

    /**
     * Creates the API object.
     *
     * @param array $config
     */
    public function __construct(ConfigurationVO $config) 
    {
        /** @var \GuzzleHttp\Client client */
        $this->client = new Client();

        try {
            $this->config = $config;
        }catch (\InvalidArgumentException $exception) {
            print($exception->getMessage());
        }
    }

    /**
     * Request to an endpoint.
     *
     * @param $endpoint
     * @param array $json
     *
     * @return mixed|null
     */
    private function getResponse($endpoint, $operation, array $json) 
    {
        $result = null;
        $uri = $this->config->getBaseUrl() . '/api/';
        $uri .= ConfigurationVO::API_VERSION . $endpoint;

        $allowedOperations = ['get', 'post'];
        if(!in_array($operation, $allowedOperations)) {
            echo 'ERROR: only ' . implode(',', $allowedOperations) . 'are allowed';
            return $result;
        }

        try {
            $response = $this->client->{$operation}($uri, [
            'headers' => [
              'Authorization' => 'Bearer ' . $this->config->getBearer(),
            ],
            'json' => $json,
            ]);
            // @todo $request->getHeader('content-type')
            if($response instanceof ResponseInterface
              && $response->getStatusCode() == '200') {
                $result = json_decode($response->getBody(), true);
            }else{
                echo 'ERROR: Status code ' . $response->getStatusCode();
            }
            // @todo check thrown exception
        } catch (\Exception $exception) {
            echo 'ERROR: ' . $exception->getMessage();
        }
        return $result;
    }

    /**
     * Get operation.
     *
     * @param $endpoint
     * @param array $params
     *
     * @return mixed|null
     */
    public function get($endpoint, array $params = []) 
    {
        return $this->getResponse($endpoint, 'get', $params);
    }

    /**
     * Post operation.
     *
     * @param $endpoint
     * @param array $params
     *
     * @return mixed|null
     */
    public function post($endpoint, array $params = []) 
    {
        return $this->getResponse($endpoint, 'post', $params);
    }

    /**
     * Delete operation.
     *
     * @param $endpoint
     * @param array $params
     *
     * @return mixed|null
     */
    public function delete($endpoint, array $params = []) 
    {
        // @todo implement
    }

    public function stream($endpoint) 
    {
        // @todo implement
    }

}
