<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\ApiTestTrait;
use App\Models\Tenant\User;
use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

uses(Tests\TestCase::class);

test('create_user', function () {
    $user = factory(User::class)->make()->toArray();
    $this->response = $this->json( 'POST', '/api/users', $user );
    $this->assertApiResponse($user);
    }

test('read_user', function () {
    $user = factory(User::class)->create();
    $this->response = $this->json( 'GET', '/api/users/' . $user->id );
    $this->assertApiResponse($user->toArray());
    }

test('update_user', function () {
    $user = factory(User::class)->create();
    $editedUser = factory(User::class)->make()->toArray();
    $this->response = $this->json( 'PUT', '/api/users/' . $user->id, $editedUser );
    $this->assertApiResponse($editedUser);
    }

test('delete_user', function () {
    $user = factory(User::class)->create();
    $this->response = $this->json( 'DELETE', '/api/users/' . $user->id );
    $this->assertApiSuccess();
    $this->response = $this->json( 'GET', '/api/users/' . $user->id );
    $this->response->assertStatus(404);
    }
