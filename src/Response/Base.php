<?php

namespace BoldBrush\Cloudflare\API\Response;

class Base
{
    public function set($key, $val)
    {
        $this->$key = $val;

        return $this;
    }

    public function get($key, $default = null)
    {
        if (isset($this->$key)) {
            return $this->$key;
        }

        return $default;
    }
}