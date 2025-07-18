<?php

namespace App\Integration;

use Request;
use InvalidArgumentException;
use App\Models\Tenant\Channel;

abstract class ChannelCallback
{
    protected $channel;

    /**
     * @param string $channelCode
     * @return void
     * @throws InvalidArgumentException
     */
    public function __construct($channelCode)
    {
        $this->channel = Channel::where('code', $channelCode)->first();
    }

    /**
     * @param Request $request
     * @return void
     */
    abstract public function process($request);
}
