<?php

namespace Tests\Unit\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Tenant\Invoice;

class InvoiceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_invoice()
    {
        $invoice = factory(Invoice::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/invoices',
            $invoice
        );

        $this->assertApiResponse($invoice);
    }

    /**
     * @test
     */
    public function test_read_invoice()
    {
        $invoice = factory(Invoice::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/invoices/' . $invoice->id
        );

        $this->assertApiResponse($invoice->toArray());
    }

    /**
     * @test
     */
    public function test_update_invoice()
    {
        $invoice = factory(Invoice::class)->create();
        $editedInvoice = factory(Invoice::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/invoices/' . $invoice->id,
            $editedInvoice
        );

        $this->assertApiResponse($editedInvoice);
    }

    /**
     * @test
     */
    public function test_delete_invoice()
    {
        $invoice = factory(Invoice::class)->create();

        $this->response = $this->json(
            'DELETE',
            '/api/invoices/' . $invoice->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/invoices/' . $invoice->id
        );

        $this->response->assertStatus(404);
    }
}
