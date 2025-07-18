<?php

namespace App\Integration;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Contracts\Container\BindingResolutionException;
use App\Models\Tenant\Channel;

abstract class ChannelAuth
{
    protected $channel;
    protected string $redirectUri;

    /**
     * @param Channel $channel
     * @return void
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     */
    public function __construct($channel)
    {
        $this->channel = $channel;
        $this->redirectUri = route('channels-callback.auth', ['channel' => $channel->code]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    abstract public function authenticate($request);
}
