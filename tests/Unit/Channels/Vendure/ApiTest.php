<?php

namespace Tests\Unit\Channels\Vendure;

use Tests\TestCase;
use App\Integration\Channels\Vendure\Api;
use Illuminate\Foundation\Testing\RefreshDatabase;

/** @package Tests\Unit\Channels\Vendure */
class ApiTest extends TestCase
{
    use RefreshDatabase;

    private Api $subject;
    private array $sourceProducts;

    public function setUp(): void
    {
        //parent::setUp();

        $this->subject = new Api('https://proveit.zhf.app/api/admin', 'zhfmd', 'zhfmd');
    }

    /**
     * @vcr vendure_api_test_get_products
     */
    public function testGetProducts()
    {
    }

    /** @return void  */
    public function testSend(): void
    {
        $result = $this->subject->login();

        dd($result);
        // $response = $this->subject->send($this->sourceProducts);

        // $spy = $this->spy(\Automattic\WooCommerce\Client::class);

        // $spy->shouldReceive('get');
    }
}
