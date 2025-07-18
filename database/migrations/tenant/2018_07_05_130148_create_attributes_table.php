<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();

            $table->string('code');
            $table->string('name');
            $table->string('input_type');
            $table->boolean('is_required')->default(false);
            $table->boolean('value_per_channel')->default(false);
            $table->boolean('is_configurable')->default(true);
            $table->boolean('is_user_defined')->default(true);
            $table->text('default_value')->nullable();

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
        Schema::dropIfExists('attributes');
    }
}
