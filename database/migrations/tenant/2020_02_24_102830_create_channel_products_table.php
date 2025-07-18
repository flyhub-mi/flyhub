<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_products', function (Blueprint $table) {
            $table->id();

            $table->string('remote_product_id')->nullable();
            $table->string('remote_category_id')->nullable();
            $table->string('remote_initial_quantity')->default(0);
            $table->string('remote_sold_quantity')->default(0);
            $table->string('remote_link')->nullable();

            $table->boolean('status')->default(true);

            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('restrict');

            $table->unique(['product_id', 'channel_id']);

            $table->dateTime('last_received_at')->nullable();
            $table->dateTime('last_send_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_products');
    }
}
