<?php

namespace App\Integration\Channels\Sisplan\Resources;

use App\Integration\ChannelResource;
use App\Integration\Channels\Sisplan\Api;
use App\Integration\Channels\Sisplan\Mapping\ProductMapper;
use App\Integration\Mapping\Utils;
use Carbon\Carbon;

use function _\get;

class Products extends ChannelResource
{
    protected $api;
    protected $mapper;

    /**
     * @param \App\Models\Tenant\Channel $channel
     */
    public function __construct($channel)
    {
        parent::__construct($channel);

        $this->api = new Api($this->configs);
        $this->mapper = new ProductMapper($channel, $this->configs);
    }

    /**
     * @param int $pg
     * @param null|string $lastReceivedAt
     * @return array
     */
    public function receive($pg = 1, $lastReceivedAt = null)
    {
        $params = [];
        if (!is_null($lastReceivedAt)) {
            $params['data_modificacao'] = Carbon::parse($lastReceivedAt)->format('Y-m-d H:i:s');
        }

        $remoteList = $this->api->get('rest/produto', $params);
        $itemToMapper = $this->prepareItemsToMapper($remoteList);
        $result = array_map(fn($item) => $this->mapper->toLocal($item), $itemToMapper);

        $this->updateLastReceivedAt(last($remoteList)['data_modificacao']);

        return $result;
    }

    private function prepareItemsToMapper($remoteList)
    {
        $items = [];

        foreach ($remoteList as $remoteItem) {
            $remoteVariations = get($remoteItem, 'estoque', []);
            $variationsByColor = Utils::groupBy($remoteVariations, 'cor.descricao');

            foreach (array_keys($variationsByColor) as $color) {
                $variations = $variationsByColor[$color];

                $remoteItem['cor'] = head($variations)['cor'];
                $remoteItem['estoque'] = array_map(
                    fn($variation) => array_merge($variation, [
                        'descricao' => $remoteItem['descricao'],
                        'preco' => $remoteItem['preco'],
                    ]),
                    $variations,
                );

                $items[] = $remoteItem;
            }
        }

        return $items;
    }
}
