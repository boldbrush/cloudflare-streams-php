<?php

namespace BoldBrush\Cloudflare\API;

use BoldBrush\Cloudflare\API\Adapter\Curl;
use BoldBrush\Cloudflare\API\Auth\Auth;
use BoldBrush\Cloudflare\API\Enpoints\Streams;

class Factory
{
    public static function make($account, $key, $email)
    {
        $auth = new Auth($account, $key, $email);
        $adapter = new Curl($auth);

        return new Streams($adapter);
    }
}
