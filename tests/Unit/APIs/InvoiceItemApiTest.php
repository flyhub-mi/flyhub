<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\InvoiceItem;

class InvoiceItemApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_invoice_item()
    {
        $invoiceItem = factory(InvoiceItem::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/invoice-items',
            $invoiceItem
        );

        $this->assertApiResponse($invoiceItem);
    }

    /**
     * @test
     */
    public function test_read_invoice_item()
    {
        $invoiceItem = factory(InvoiceItem::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/invoice-items/' . $invoiceItem->id
        );

        $this->assertApiResponse($invoiceItem->toArray());
    }

    /**
     * @test
     */
    public function test_update_invoice_item()
    {
        $invoiceItem = factory(InvoiceItem::class)->create();
        $editedInvoiceItem = factory(InvoiceItem::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/invoice-items/' . $invoiceItem->id,
            $editedInvoiceItem
        );

        $this->assertApiResponse($editedInvoiceItem);
    }

    /**
     * @test
     */
    public function test_delete_invoice_item()
    {
        $invoiceItem = factory(InvoiceItem::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/invoice-items/' . $invoiceItem->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/invoice-items/' . $invoiceItem->id
        );

        $this->response->assertStatus(404);
    }
}
