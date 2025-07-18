<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Tenant\Channel;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Integration\Mapping\Utils;
use Illuminate\Routing\Redirector;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\BaseController;
use App\Repositories\Tenant\ChannelRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ChannelController extends BaseController
{
    private $modelRepository;

    /**
     * @param ChannelRepository $modelRepository
     * @return void
     */
    public function __construct(ChannelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $channelGroups = [
            'MarketPlace' => [
                'Dafiti' => Channel::where('code', 'Dafiti')->first(),
                'MercadoLivre' => Channel::where('code', 'MercadoLivre')->first(),
                'Netshoes' => Channel::where('code', 'Netshoes')->first(),
            ],
            'E-Commerce' => [
                'LojaIntegrada' => Channel::where('code', 'LojaIntegrada')->first(),
                'Magento' => Channel::where('code', 'Magento')->first(),
                'Magento2' => Channel::where('code', 'Magento2')->first(),
                'Medusa' => Channel::where('code', 'Medusa')->first(),
                'WooCommerce' => Channel::where('code', 'WooCommerce')->first(),
                'Vendure' => Channel::where('code', 'Vendure')->first(),
            ],
            'ERP' => [
                'Bling' => Channel::where('code', 'Bling')->first(),
                'Sisplan' => Channel::where('code', 'Sisplan')->first(),
            ],
            'Transportadoras' => [
                'SSW' => Channel::where('code', 'SSW')->first(),
                'TotalExpress' => Channel::where('code', 'TotalExpress')->first(),
            ],
        ];

        return view('tenant.channels.index')->with('channelGroups', $channelGroups);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        $channel = $request->input('activate');
        $configNameSpace = Utils::buildNamespace('App\Integration\Channels', $channel, 'Config');
        $configFields = $configNameSpace::fields();

        return view('tenant.channels.create')
            ->with('channel', $channel)
            ->with('configFields', $configFields);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return View|Factory
     * @throws BindingResolutionException
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $channel = $this->modelRepository->create($input);

        Flash::success('Canal ativado.');

        return redirect(route('channels.index', ['id' => $channel->id]));
    }

    /**
     * @param mixed $id
     * @return Redirector|RedirectResponse|View|Factory
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     */
    public function show($id)
    {
        $channel = $this->modelRepository->find($id);

        if (is_null($channel)) {
            Flash::error('Canal não encontrado.');

            return redirect(route('channels.index'));
        }

        $url = '';

        if ($channel->code === 'MercadoLivre') {
            $auth = new \App\Integration\Channels\MercadoLivre\Auth($channel);
            $url = $auth->oAuthUrl();
        }

        return view('tenant.channels.show')
            ->with('channel', $channel)
            ->with('url', $url);
    }

    /**
     * @param mixed $id
     * @return Redirector|RedirectResponse|View|Factory
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     */
    public function edit($id)
    {
        $channel = $this->modelRepository->find($id);

        if (is_null($channel)) {
            Flash::error('Canal não encontrado.');

            return redirect(route('channels.index'));
        }

        /** @var \App\Integration\ChannelConfig $configClass */
        $configClass = Utils::buildNamespace('App\Integration\Channels', $channel->code, 'Config');

        return view('tenant.channels.edit')
            ->with('channel', $channel)
            ->with('channel_configs', $channel->configs->pluck('value', 'code'))
            ->with('channel_config_fields', $configClass::fields()->toJson());
    }

    /**
     * @param mixed $id
     * @param \Illuminate\Http\Request $request
     * @return Redirector|RedirectResponse
     * @throws BindingResolutionException
     * @throws RouteNotFoundException
     */
    public function update($id, Request $request)
    {
        $input = $request->input();
        $channel = $this->modelRepository->find($id);

        if (is_null($channel)) {
            Flash::error('Canal não encontrado.');

            return redirect(route('channel.auth'));
        }

        $this->modelRepository->update($input);

        Flash::success('Canal atualizado.');

        return redirect(route('channel.notifications'));
    }
}
