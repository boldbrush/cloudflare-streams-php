<?php

namespace BoldBrush\Cloudflare\API\Adapter;

use BoldBrush\Cloudflare\API\Auth\Auth;
use BoldBrush\Cloudflare\API\Response\ErrorResponse;
use BoldBrush\Cloudflare\API\Response\Util;

class Curl implements AdapterInterface
{
    const BASE_HOST = '';

    /** @var Auth */
    protected $auth;

    /** @var string */
    protected $base;

    public function __construct(Auth $auth, $baseURI = null)
    {
        $this->auth = $auth;

        if ($baseURI === null) {
            $baseURI = 'https://api.cloudflare.com/client/v4/accounts/';
        }

        $this->base = $baseURI;
    }

    /**
     * {@inheritdoc}
     */
    public function get($uri, array $data = [], array $headers = [], $raw = false)
    {
        $uri = $this->makeUri($uri);
        $headers = $this->makeHeaders($headers);

        $response = $this->makeRequest('GET', $uri, $data, $headers, $raw);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $data = [], array $headers = [], $raw = false)
    {
        $data = json_encode($data);
        $h = ['Content-Length' => strlen($data)];

        $headers = array_merge($headers, $h);

        $uri = $this->makeUri($uri);
        $headers = $this->makeHeaders($headers);

        $response = $this->makeRequest('POST', $uri, $data, $headers, $raw);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function delete($uri, array $data = [], array $headers = [], $raw = false)
    {
        $uri = $this->makeUri($uri);
        $headers = $this->makeHeaders($headers);

        $response = $this->makeRequest('DELETE', $uri, $data, $headers, $raw);

        return $response;
    }

    protected function makeUri($uri)
    {
        $acccount = $this->auth->getAccount();

        return $this->base . $acccount . '/' . ltrim($uri, '/');
    }

    protected function makeHeaders($headers = [])
    {
        $headers = array_merge($headers,
            $this->auth->getHeaders(),
            [
                'Content-Type' => 'application/json',
                'Cache-Control' => 'no-cache',
                'purge_everything' => ' true',
            ]
        );

        $h = [];

        foreach ($headers as $key => $value) {
            $h[] = "{$key}: {$value}";
        }

        return $h;
    }

    protected function makeRequest($method, $uri, $data = '{}', $headers = [], $raw = false)
    {
        $ch = curl_init();
        $options = array(
            CURLOPT_RETURNTRANSFER => true,         // return web page
            CURLOPT_FOLLOWLOCATION => true,         // follow redirects
            CURLOPT_USERAGENT      => "BoldBrush Agent",     // who am i
            CURLOPT_AUTOREFERER    => true,         // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,          // timeout on connect
            CURLOPT_TIMEOUT        => 120,          // timeout on response
            CURLOPT_MAXREDIRS      => 10,           // stop after 10 redirects
            CURLOPT_SSL_VERIFYHOST => 0,            // don't verify ssl
            CURLOPT_SSL_VERIFYPEER => false,        //
            CURLOPT_VERBOSE        => 1                //
        );

        curl_setopt_array($ch, $options);

        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if (strtolower($method) === 'post') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        if (strtolower($method) === 'delete') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);

        $info = curl_getinfo($ch);

        if (curl_errno($ch)) {
            $e = new ErrorResponse();
            $e->setError(Util::error($info));

            throw $e;
        }

        if ($response === false || $info['http_code'] > 399) {
            $e = new ErrorResponse();
            $e->setError(Util::error($info));

            throw $e;
        }

        curl_close($ch);

        if ($raw === false) {
            $response = json_decode($response, true);
        }

        return $response;
    }
}
