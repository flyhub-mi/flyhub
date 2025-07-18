<?php

namespace Tests\Unit\Channels\WooCommerce;

use App\Integration\Channels\WooCommerce\Products;
use App\Models\Tenant\Channel;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductsTest extends TestCase
{
    use RefreshDatabase;

    private Products $subject;
    private array $sourceProducts;

    public function setUp(): void
    {
        parent::setUp();

        $this->sourceProducts = json_decode(file_get_contents("source_products.json"), true);
        Http::fake(['*' => Http::response($this->sourceProducts, 200)]);

        $channel = new Channel(['id' => 1, 'code' => 'WooCommerce', 'name' => 'WooCommerce']);
        $configs = ['apiKey' => 'chave-api'];

        $this->subject = new Products($channel, $configs);
    }

    public function tearDown(): void
    {
        $this->subject = null;
    }

    public function testSend(): void
    {
        $response = $this->subject->send($this->sourceProducts);

        $spy = $this->spy(\Automattic\WooCommerce\Client::class);

        $spy->shouldReceive('get');
    }
}
