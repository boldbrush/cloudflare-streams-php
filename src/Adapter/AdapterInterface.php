<?php

namespace BoldBrush\Cloudflare\API\Adapter;

use BoldBrush\Cloudflare\API\Auth\Auth;

interface AdapterInterface
{
    /**
     * Adapter constructor.
     *
     * @param Auth $auth
     * @param string $baseURI
     */
    public function __construct(Auth $auth, $baseURI);

    /**
     * Sends a GET request.
     * Per Robustness Principle - not including the ability to send a body with a GET request (though possible in the
     * RFCs, it is never useful).
     *
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function get($uri, array $data = [], array $headers = [], $raw = false);

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function post($uri, array $data = [], array $headers = [], $raw = false);

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     *
     * @return mixed
     */
    public function delete($uri, array $data = [], array $headers = [], $raw = false);
}