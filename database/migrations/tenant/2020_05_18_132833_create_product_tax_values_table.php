<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTaxValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_tax_values', function (Blueprint $table) {
            $table->id();

            $table->string('tag')->nullable();

            $table->boolean('manual')->default(false);

            $table->string('string_value')->nullable();
            $table->double('double_value')->nullable();
            $table->integer('integer_value')->nullable();

            $table->string('formula')->nullable();
            $table->string('formula_values')->nullable();

            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('tax_id');
            $table->unsignedBigInteger('tax_group_id');

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');
            $table->foreign('tax_group_id')->references('id')->on('tax_groups')->onDelete('cascade');

            $table->unique(['product_id', 'tag']);

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
        Schema::dropIfExists('product_tax_values');
    }
}
