<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();

            $table->string('tag')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('size');
            $table->longtext('description')->nullable();
            $table->decimal('tax_rate', 12, 4)->default(0);
            $table->string('formula')->nullable();
            $table->boolean('required')->default(false);
            $table->boolean('visible')->default(true);
            $table->decimal('default_value', 12, 4)->nullable();

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
        Schema::dropIfExists('taxes');
    }
}
