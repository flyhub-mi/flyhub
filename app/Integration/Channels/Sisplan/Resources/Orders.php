<?php

namespace App\Integration\Channels\Sisplan\Resources;

use App\FlyHub;
use App\Integration\ChannelResource;
use App\Integration\Channels\Sisplan\Api;
use App\Integration\Channels\Sisplan\Mapping\OrderMapper;

class Orders extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     * @param array $configs
     */
    public function __construct($channel)
    {
        parent::__construct($channel);

        $this->api = new Api($this->configs);
        $this->mapper = new OrderMapper($channel, $this->configs);
    }

    /**
     * @param array $localOrder
     * @return array
     */
    public function send($localOrder)
    {
        $this->throwsErrorIfOrderAlreadyWasSent($localOrder['id']);

        $mappedData = $this->mapper->toRemote($localOrder);
        $mappedData['customer'] = $this->sendCustomer($localOrder['customer']);

        $response = $this->api->put('rest/pedido', $mappedData);

        if (isset($response['numero'])) {
            $this->saveChannelOrder($localOrder['id'], $response['numero']);
        } else {
            FlyHub::notifyExceptionWithMetaData('Erro ao enviar pedido', [$localOrder, $response], true);
        }

        return $response;
    }

    private function sendCustomer($customerData)
    {
        $result = $this->api->getCustomer($customerData['cnpj']);

        isset($result['codcli'])
            ? $this->api->post('rest/entidade', array_merge($result, $customerData)) // update
            : $this->api->put('rest/entidade', $customerData); // create

        $result = $this->api->getCustomer($customerData);

        if (!isset($result['codcli'])) {
            FlyHub::notifyExceptionWithMetaData('Erro ao criar cliente', [$customerData, $result], true);
        }

        return ['codcli' => $result['codcli']];
    }
}
