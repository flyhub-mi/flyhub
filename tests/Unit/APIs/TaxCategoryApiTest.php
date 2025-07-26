<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\TaxGroup;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_tax_category', function () {
    $taxCategory = factory(TaxGroup::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/tax-groups', $taxCategory );
    $this->assertApiResponse($taxCategory);
    }

test('read_tax_category', function () {
    $taxCategory = factory(TaxGroup::class)->create();
    $this->response = $this->json( 'GET', '/api/tax-groups/' . $taxCategory->id );
    $this->assertApiResponse($taxCategory->toArray());
    }

test('update_tax_category', function () {
    $taxCategory = factory(TaxGroup::class)->create();
    $editedTaxCategory = factory(TaxGroup::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/tax-groups/' . $taxCategory->id, $editedTaxCategory );
    $this->assertApiResponse($editedTaxCategory);
    }

test('delete_tax_category', function () {
    $taxCategory = factory(TaxGroup::class)->create();
    $this->response = $this->json( 'DELETE', '/api/tax-groups/' . $taxCategory->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/tax-groups/' . $taxCategory->id );
    $this->response->assertStatus(404);
    }
