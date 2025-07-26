<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Invoice;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_invoice', function () {
    $invoice = factory(Invoice::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/invoices', $invoice );
    $this->assertApiResponse($invoice);
    }

test('read_invoice', function () {
    $invoice = factory(Invoice::class)->create();
    $this->response = $this->json( 'GET', '/api/invoices/' . $invoice->id );
    $this->assertApiResponse($invoice->toArray());
    }

test('update_invoice', function () {
    $invoice = factory(Invoice::class)->create();
    $editedInvoice = factory(Invoice::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/invoices/' . $invoice->id, $editedInvoice );
    $this->assertApiResponse($editedInvoice);
    }

test('delete_invoice', function () {
    $invoice = factory(Invoice::class)->create();
    $this->response = $this->json( 'DELETE', '/api/invoices/' . $invoice->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/invoices/' . $invoice->id );
    $this->response->assertStatus(404);
    }
