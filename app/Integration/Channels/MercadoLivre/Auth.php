<?php

namespace App\Integration\Channels\MercadoLivre;

use App\Integration\ChannelAuth;
use App\Integration\Channels\MercadoLivre\Api;

class Auth extends ChannelAuth
{

    /** @var \Dsc\MercadoLivre\Resources\Authorization\AuthorizationService $authService */
    protected $authService;

    /** @var string $authService */
    protected string $redirectUri = '';

    /**
     * Auth constructor.
     * @param $channel
     */
    public function __construct($channel)
    {
        $this->authService = (new Api($channel))->authService;

        parent::__construct($channel);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function authenticate($request)
    {
        if (!$request->has('code')) return false;

        return !empty($this->authService->authorize($request->input('code'), $this->redirectUri));
    }

    /**
     * @return string
     */
    public function oAuthUrl()
    {
        return $this->authService->getOAuthUrl($this->redirectUri);
    }

    /**
     * @return string
     */
    public function refreshToken()
    {
        return $this->authService->getAccessToken();
    }
}
