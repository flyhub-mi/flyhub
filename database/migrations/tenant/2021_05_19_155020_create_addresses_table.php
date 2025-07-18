<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::create('addresses', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->timestamps();

                $table->string('address_type');

                $table->string('name')->nullable();
                $table->string('gender')->nullable();
                $table->string('cpf_cnpj')->nullable();
                $table->string('email')->nullable();
                $table->string('phone')->nullable();

                $table->string('street');
                $table->string('number')->nullable();
                $table->string('complement')->nullable();
                $table->string('neighborhood')->nullable();

                $table->string('country');
                $table->string('postcode');
                $table->string('state');
                $table->string('city');

                $table->json('metadata')->nullable();

                $table->unsignedBigInteger('order_id')->nullable();
                $table->foreign(['order_id'])->references('id')->on('orders')->onDelete('set null');

                $table->unsignedBigInteger('customer_id')->nullable();
                $table->foreign(['customer_id'])->references('id')->on('customers')->onDelete('set null');
            });
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        throw new Exception('you cannot revert this migration: data would be lost');
    }
}
