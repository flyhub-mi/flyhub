<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeFamilyMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_set_mappings', function (Blueprint $table) {
            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');

            $table->unsignedBigInteger('attribute_set_id');
            $table->foreign('attribute_set_id')->references('id')->on('attribute_sets')->onDelete('cascade');

            $table->unique(['attribute_id', 'attribute_set_id'], 'attribute_set_map_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_set_mappings');
    }
}
