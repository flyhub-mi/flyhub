<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_groups', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->integer('position');
            $table->boolean('is_user_defined')->default(true);

            $table->unsignedBigInteger('attribute_set_id');
            $table->foreign('attribute_set_id')->references('id')->on('attribute_sets')->onDelete('cascade');

            $table->unique(['attribute_set_id', 'name']);

            $table->timestamps();
        });

        Schema::create('attribute_group_mappings', function (Blueprint $table) {
            $table->integer('position')->nullable();

            $table->unsignedBigInteger('attribute_id');
            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');

            $table->unsignedBigInteger('attribute_group_id');
            $table->foreign('attribute_group_id')->references('id')->on('attribute_groups')->onDelete('cascade');

            $table->primary(['attribute_id', 'attribute_group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_group_mappings');

        Schema::dropIfExists('attribute_groups');
    }
}
