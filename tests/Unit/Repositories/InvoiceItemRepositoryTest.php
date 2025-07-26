<?php

use App\Models\Tenant\InvoiceItem;
use App\Repositories\InvoiceItemRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->make()->toArray();
    $createdInvoiceItem = $this->invoiceItemRepo->create($invoiceItem);
    $createdInvoiceItem = $createdInvoiceItem->toArray();
    $this->assertArrayHasKey('id', $createdInvoiceItem);
    $this->assertNotNull($createdInvoiceItem['id'], 'Created InvoiceItem must have id specified');
    $this->assertNotNull(InvoiceItem::find($createdInvoiceItem['id']), 'InvoiceItem with given id must be in DB');
    $this->assertModelData($invoiceItem, $createdInvoiceItem);
    }

test('read_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->create();
    $dbInvoiceItem = $this->invoiceItemRepo->find($invoiceItem->id);
    $dbInvoiceItem = $dbInvoiceItem->toArray();
    $this->assertModelData($invoiceItem->toArray(), $dbInvoiceItem);
    }

test('update_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->create();
    $fakeInvoiceItem = factory(InvoiceItem::class)->make()->toArray();
    $updatedInvoiceItem = $this->invoiceItemRepo->update($fakeInvoiceItem, $invoiceItem->id);
    $this->assertModelData($fakeInvoiceItem, $updatedInvoiceItem->toArray());
    $dbInvoiceItem = $this->invoiceItemRepo->find($invoiceItem->id);
    $this->assertModelData($fakeInvoiceItem, $dbInvoiceItem->toArray());
    }

test('delete_invoice_item', function () {
    $invoiceItem = factory(InvoiceItem::class)->create();
    $resp = $this->invoiceItemRepo->delete($invoiceItem->id);
    $this->assertTrue($resp);
    $this->assertNull(InvoiceItem::find($invoiceItem->id), 'InvoiceItem should not exist in DB');
    }
