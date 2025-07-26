<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\InvoiceItem;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/invoice-items', $invoiceItem );
    $this->assertApiResponse($invoiceItem);
    }

test('read_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->create();
    $this->response = $this->json( 'GET', '/api/invoice-items/' . $invoiceItem->id );
    $this->assertApiResponse($invoiceItem->toArray());
    }

test('update_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->create();
    $editedInvoiceItem = factory(InvoiceItem::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/invoice-items/' . $invoiceItem->id, $editedInvoiceItem );
    $this->assertApiResponse($editedInvoiceItem);
    }

test('delete_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->create();
    $this->response = $this->json( 'DELETE', '/api/invoice-items/' . $invoiceItem->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/invoice-items/' . $invoiceItem->id );
    $this->response->assertStatus(404);
    }
