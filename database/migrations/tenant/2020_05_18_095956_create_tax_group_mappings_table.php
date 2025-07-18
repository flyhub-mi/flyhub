<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxGroupMappingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_group_mappings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('tax_group_id');
            $table->unsignedBigInteger('tax_id');

            $table->integer('position')->default(1);

            $table->foreign('tax_group_id')->references('id')->on('tax_groups')->onDelete('cascade');
            $table->foreign('tax_id')->references('id')->on('taxes')->onDelete('cascade');

            $table->unique(['tax_group_id', 'tax_id'], 'tax_group_map_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_group_mappings');
    }
}
