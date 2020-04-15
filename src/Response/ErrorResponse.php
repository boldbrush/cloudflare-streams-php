<?php

namespace BoldBrush\Cloudflare\API\Response;

use Exception;

class ErrorResponse extends Exception
{
    private $error;

    public function setError(Error $error)
    {
        $this->error = $error;

        return $this;
    }

    public function getError()
    {
        return $this->error;
    }
}