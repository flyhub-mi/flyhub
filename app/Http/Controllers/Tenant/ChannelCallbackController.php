<?php

namespace App\Http\Controllers\Tenant;

use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Jobs\Tenant\ChannelCallbackJob;
use App\Integration\Mapping\Utils;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\ChannelRepository;

class ChannelCallbackController extends BaseController
{
    private $modelRepository;

    /**
     * @param ChannelRepository $modelRepository
     * @return void
     */
    public function __construct($modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $channelCode
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function auth(Request $request, $channelCode)
    {
        $channel = $this->modelRepository->findOneBy(['code', $channelCode]);

        if (is_null($channel)) {
            Flash::error('Canal não encontrado.');

            return redirect(route('channels.index'));
        }

        $channelAuthClass = Utils::buildNamespace('App\Integration\Channels', $channelCode, 'Auth');
        $channelAuthInstance = new $channelAuthClass($channel, $request);

        return $channelAuthInstance->authenticate()
            ? redirect(route('channels.edit', [$channel]))
            : redirect(route('channels.show', [$channel]));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $channelCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function notifications($request, $channelCode)
    {
        ChannelCallbackJob::dispatch($channelCode, $request);

        return $this->sendResponse([], 'Notificação agendada para processamento.');
    }
}
