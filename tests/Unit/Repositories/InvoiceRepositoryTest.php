<?php

use App\Models\Tenant\Invoice;
use App\Repositories\InvoiceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_invoice', function () {
    $invoice = factory(Invoice::class)->make()->toArray();
    $createdInvoice = $this->invoiceRepo->create($invoice);
    $createdInvoice = $createdInvoice->toArray();
    $this->assertArrayHasKey('id', $createdInvoice);
    $this->assertNotNull($createdInvoice['id'], 'Created Invoice must have id specified');
    $this->assertNotNull(Invoice::find($createdInvoice['id']), 'Invoice with given id must be in DB');
    $this->assertModelData($invoice, $createdInvoice);
    }

test('read_invoice', function () {
    $invoice = factory(Invoice::class)->create();
    $dbInvoice = $this->invoiceRepo->find($invoice->id);
    $dbInvoice = $dbInvoice->toArray();
    $this->assertModelData($invoice->toArray(), $dbInvoice);
    }

test('update_invoice', function () {
    $invoice = factory(Invoice::class)->create();
    $fakeInvoice = factory(Invoice::class)->make()->toArray();
    $updatedInvoice = $this->invoiceRepo->update($fakeInvoice, $invoice->id);
    $this->assertModelData($fakeInvoice, $updatedInvoice->toArray());
    $dbInvoice = $this->invoiceRepo->find($invoice->id);
    $this->assertModelData($fakeInvoice, $dbInvoice->toArray());
    }

test('delete_invoice', function () {
    $invoice = factory(Invoice::class)->create();
    $resp = $this->invoiceRepo->delete($invoice->id);
    $this->assertTrue($resp);
    $this->assertNull(Invoice::find($invoice->id), 'Invoice should not exist in DB');
    }
