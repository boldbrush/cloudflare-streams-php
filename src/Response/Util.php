<?php

namespace BoldBrush\Cloudflare\API\Response;

class Util
{
    public static function stream($stream = [])
    {
        $obj = new Stream();
        foreach ($stream as $key => $value) {
            if (is_array($value) && empty($value)) {
                $value = null;
            }
            if (is_array($value)) {
                $value = self::base($value);
            }

            $obj->set($key, $value);
        }

        return $obj;
    }

    public static function base($base = [])
    {
        $obj = new Base();
        foreach ($base as $key => $value) {
            if (is_array($value)) {
                $value = self::base($value);
            }

            $obj->set($key, $value);
        }

        return $obj;
    }

    public static function error($base = [])
    {
        $obj = new Error();
        foreach ($base as $key => $value) {
            if (is_array($value)) {
                $value = self::base($value);
            }

            $obj->set($key, $value);
        }

        return $obj;
    }
}