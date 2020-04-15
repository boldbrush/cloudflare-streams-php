<?php

namespace BoldBrush\Cloudflare\API\Enpoints;

use BoldBrush\Cloudflare\API\Adapter\AdapterInterface;
use BoldBrush\Cloudflare\API\Response\Builder;
use BoldBrush\Cloudflare\API\Response\ErrorResponse;

class Streams
{
    protected $adapter;

    protected $builder;

    public function __construct(AdapterInterface $adapter)
    {
        $this->builder = new Builder();
        $this->adapter = $adapter;
    }

    public function getStreams()
    {
        try {
            $streams = $this->builder->build(
                $this->adapter->get('/stream')
            );
        } catch (ErrorResponse $e) {
            return $e->getError();
        }

        return $streams;
    }

    public function getStream($identifier)
    {
        try {
            $stream = $this->builder->build(
                $this->adapter->get('/stream/' . $identifier)
            );
        } catch (ErrorResponse $e) {
            return $e->getError();
        }

        return $stream;
    }

    public function getEmbedSnippet($identifier)
    {
        try {
            $snippet = $this->adapter->get('/stream/' . $identifier . '/embed', [], [], true);
        } catch (ErrorResponse $e) {
            return $e->getError();
        }

        return $snippet;
    }

    public function copy($url, $name = null)
    {
        if ($name === null) {
            $name = strval(time());
        }
        try {
            $stream = $this->builder->build(
                $this->adapter->post('/stream/copy', [
                    'url' => $url,
                    'meta' => ['name' => $name],
                ])
            );
        } catch (ErrorResponse $e) {
            return $e->getError();
        }

        return $stream;
    }

    public function delete($identifier)
    {
        try {
            $stream = $this->adapter->delete('/stream/' . $identifier);
        } catch (ErrorResponse $e) {
            return $e->getError();
        }

        return $stream === null;
    }
}
