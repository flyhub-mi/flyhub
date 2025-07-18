<?php

namespace App\Integration\Channels\MercadoLivre;

use App\Integration\Channels\MercadoLivre\Api\Storage;
use App\Models\Tenant\Channel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Dsc\MercadoLivre\Announcement;
use Dsc\MercadoLivre\Announcement\Item;
use Dsc\MercadoLivre\Announcement\ItemResponse;
use Dsc\MercadoLivre\Environments\Test;
use Dsc\MercadoLivre\Environments\Production;
use Dsc\MercadoLivre\Environments\Site;
use Dsc\MercadoLivre\Configuration;
use Dsc\MercadoLivre\Meli;
use Dsc\MercadoLivre\Requests\Category\Category;
use Dsc\MercadoLivre\Requests\Category\CategoryService;
use Dsc\MercadoLivre\Resources\Authorization\AuthorizationService;
use Dsc\MercadoLivre\Resources\Order\Order;
use Dsc\MercadoLivre\Resources\Order\OrderService;
use Dsc\MercadoLivre\Resources\Shipment\Shipment;
use Dsc\MercadoLivre\Resources\Shipment\ShipmentService;
use GuzzleHttp\Exception\InvalidArgumentException;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class Api
{
    protected $client;
    protected $storage;
    protected $sellerId;
    public $authService;

    /**
     * MeliService constructor.
     * @param Channel|null $channel
     */
    public function __construct($channel = null)
    {
        if (!is_null($channel)) {
            $this->storage = new Storage($channel);

            $configuration = new Configuration(null, $this->storage);
            $environment = env('MELI_ENVIRONMENT') === 'production'
                ? new Production(Site::BRASIL, $configuration)
                : new Test(Site::BRASIL, $configuration);

            $this->client = new Meli(env('MELI_CLIENT_ID'), env('MELI_CLIENT_SECRET_KEY'), $environment);
            $this->authService = new AuthorizationService($this->client);
        }
    }

    /**
     * @return ArrayCollection<Order>
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function getOrders()
    {
        return (new OrderService($this->client))->findOrdersBySeller($this->getSellerId())->getResults();
    }

    /**
     * @return string
     */
    private function getSellerId()
    {
        return $this->sellerId = $this->sellerId ?: end(explode('-', $this->storage->get('refresh_token')));
    }

    /**
     * @param $orderId
     * @return Order
     */
    public function getOrder($orderId)
    {
        return (new OrderService($this->client))->findOrder($orderId);
    }

    /**
     * @param Item $data
     * @return void
     */
    public function createAnnouncement(Item $data)
    {
        return (new Announcement($this->client))->create($data);
    }

    /**
     * @param string $id
     * @param array $data
     * @return ItemResponse
     * @throws InvalidArgumentException
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function updateAnnouncement($id, $data)
    {
        return (new Announcement($this->client))->update($id, $data);
    }

    /**
     * @param string $categoryId
     * @return ArrayCollection<Category>
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function getCategories()
    {
        return (new CategoryService())->findCategories(Site::BRASIL);
    }

    /**
     * @param string $categoryId
     * @return Category
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function getCategory($categoryId)
    {
        return (new CategoryService())->findCategory($categoryId);
    }

    /**
     * @param string $categoryId
     * @return ArrayCollection
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function getCategoryChildrens($categoryId)
    {
        return (new CategoryService())->findCategory($categoryId)->getChildrenCategories();
    }

    /**
     * @param string $categoryId
     * @return Collection
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function getCategoryAttributes($categoryId)
    {
        return (new CategoryService())->findCategoryAttributes($categoryId);
    }

    /**
     * @param mixed $shippingId
     * @return Shipment
     * @throws GuzzleException
     * @throws RuntimeException
     */
    public function getShipment($shippingId)
    {
        return (new ShipmentService($this->api))->findShipment($shippingId);
    }
}
