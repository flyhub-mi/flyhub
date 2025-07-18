<?php

namespace App\Integration;

use function _\endsWith;

class ChannelApi
{
    protected function prepareUrl($url)
    {
        if (endsWith($url, '/')) {
            return substr($url, 0, -1);
        }

        return $url;
    }
}
