<?php

namespace BoldBrush\Cloudflare\API\Response;

class Stream extends Base
{
    public function id()
    {
        return $this->uid;
    }

    public function status()
    {
        if (isset($this->status->step)) {
            return $this->status->step;
        }
        return $this->status->state;
    }

    public function name()
    {
        return $this->meta->name;
    }

    public function progressPercentage()
    {
        if ($this->status->state === 'ready') {
            return 100;
        }
        if (isset($this->status->pctComplete)) {
            return intval($this->status->pctComplete);
        }
        return 0;
    }
}