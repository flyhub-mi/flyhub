<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelProductAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_product_attributes', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->text('value')->nullable();

            $table->unsignedBigInteger('channel_product_id');
            $table->foreign('channel_product_id')->references('id')->on('channel_products')->onDelete('cascade');

            $table->unique(['channel_product_id', 'code']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_product_attributes');
    }
}
