<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\Tax;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_tax_rate', function () {
    $taxRate = factory(Tax::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/taxes', $taxRate );
    $this->assertApiResponse($taxRate);
    }

test('read_tax_rate', function () {
    $taxRate = factory(Tax::class)->create();
    $this->response = $this->json( 'GET', '/api/taxes/' . $taxRate->id );
    $this->assertApiResponse($taxRate->toArray());
    }

test('update_tax_rate', function () {
    $taxRate = factory(Tax::class)->create();
    $editedTaxRate = factory(Tax::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/taxes/' . $taxRate->id, $editedTaxRate );
    $this->assertApiResponse($editedTaxRate);
    }

test('delete_tax_rate', function () {
    $taxRate = factory(Tax::class)->create();
    $this->response = $this->json( 'DELETE', '/api/taxes/' . $taxRate->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/taxes/' . $taxRate->id );
    $this->response->assertStatus(404);
    }
