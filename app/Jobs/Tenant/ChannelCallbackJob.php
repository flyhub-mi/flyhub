<?php

namespace App\Jobs\Tenant;

use App\Integration\ChannelCallback;
use App\Integration\Mapping\Utils;
use FlyHub;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChannelCallbackJob extends ChannelBase implements ShouldQueue
{
    private $channelCode;
    private $request;

    /**
     * @param string $channelCode
     * @param Request $request
     * @return void
     */
    public function __construct($channelCode, $request)
    {
        $this->channelCode = $channelCode;
        $this->request = $request;
    }

    /** @return void  */
    public function handle()
    {
        try {
            /** @var ChannelCallback $callbackClass */
            $channelCallbackClass = Utils::buildNamespace('App\Integration\Channels', $this->channelCode, 'Callback');

            $channelCallbackInstance = new $channelCallbackClass($this->channelCode, $this->request);
            $channelCallbackInstance->process();
        } catch (\Exception $e) {
            FlyHub::notifyException($e);
        }
    }
}
