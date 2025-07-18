<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelInventorySourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_inventory_sources', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');

            $table->unsignedBigInteger('inventory_source_id');
            $table->foreign('inventory_source_id')->references('id')->on('inventory_sources')->onDelete('cascade');

            $table->unique(['channel_id', 'inventory_source_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channel_inventory_sources');
    }
}
