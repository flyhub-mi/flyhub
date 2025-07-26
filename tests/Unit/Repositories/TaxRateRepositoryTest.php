<?php

use App\Models\Tenant\Tax;
use App\Repositories\TaxRateRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use ApiTestTrait, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_tax_rate', function () {
    $taxRate = factory(Tax::class)->make()->toArray();
    $createdTaxRate = $this->taxRateRepo->create($taxRate);
    $createdTaxRate = $createdTaxRate->toArray();
    $this->assertArrayHasKey('id', $createdTaxRate);
    $this->assertNotNull($createdTaxRate['id'], 'Created TaxRate must have id specified');
    $this->assertNotNull(Tax::find($createdTaxRate['id']), 'TaxRate with given id must be in DB');
    $this->assertModelData($taxRate, $createdTaxRate);
    }

test('read_tax_rate', function () {
    $taxRate = factory(Tax::class)->create();
    $dbTaxRate = $this->taxRateRepo->find($taxRate->id);
    $dbTaxRate = $dbTaxRate->toArray();
    $this->assertModelData($taxRate->toArray(), $dbTaxRate);
    }

test('update_tax_rate', function () {
    $taxRate = factory(Tax::class)->create();
    $fakeTaxRate = factory(Tax::class)->make()->toArray();
    $updatedTaxRate = $this->taxRateRepo->update($fakeTaxRate, $taxRate->id);
    $this->assertModelData($fakeTaxRate, $updatedTaxRate->toArray());
    $dbTaxRate = $this->taxRateRepo->find($taxRate->id);
    $this->assertModelData($fakeTaxRate, $dbTaxRate->toArray());
    }

test('delete_tax_rate', function () {
    $taxRate = factory(Tax::class)->create();
    $resp = $this->taxRateRepo->delete($taxRate->id);
    $this->assertTrue($resp);
    $this->assertNull(Tax::find($taxRate->id), 'TaxRate should not exist in DB');
    }
