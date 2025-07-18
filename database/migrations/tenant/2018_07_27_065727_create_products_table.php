<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('sku');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->boolean('new')->nullable();
            $table->boolean('status')->nullable();
            $table->string('thumbnail')->nullable();

            $table->decimal('cost', 12, 4)->nullable();
            $table->decimal('price', 12, 4)->nullable();
            $table->decimal('min_price', 12, 4)->nullable();
            $table->decimal('max_price', 12, 4)->nullable();
            $table->decimal('special_price', 12, 4)->nullable();
            $table->date('special_price_from')->nullable();
            $table->date('special_price_to')->nullable();

            $table->string('color')->nullable();
            $table->string('size')->nullable();
            $table->string('brand')->nullable();

            $table->decimal('gross_weight', 12, 4)->nullable();
            $table->decimal('net_weight', 12, 4)->nullable();
            $table->decimal('width', 12, 4)->nullable();
            $table->decimal('height', 12, 4)->nullable();
            $table->decimal('depth', 12, 4)->nullable();

            $table->string('unit')->nullable();
            $table->string('ncm')->nullable();
            $table->string('gtin')->nullable();
            $table->string('mpn')->nullable();

            $table->string('channels')->nullable();
            $table->string('remote_id')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('attribute_set_id')->nullable();
            $table->foreign('attribute_set_id')->references('id')->on('attribute_sets')->onDelete('set null');

            $table->unsignedBigInteger('main_category_id')->nullable();
            $table->foreign('main_category_id')->references('id')->on('categories')->onDelete('set null');

            $table->timestamps();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
        });

        Schema::create('product_super_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_super_attributes');
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('products');
    }
}
