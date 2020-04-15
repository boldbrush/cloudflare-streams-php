<?php

namespace BoldBrush\Cloudflare\API\Response;

class Builder
{
    public function build(array $response)
    {
        $build = null;

        if (isset($response['result']) && is_array($response['result'])) {
            if (isset($response['result'][0])) {
                $collection = [];
                foreach ($response['result'] as $stream) {
                    $collection[] = Util::stream($stream);
                }

                $build = $collection;
            } else {
                $build = Util::stream($response['result']);
            }
        }

        return $build;
    }
}