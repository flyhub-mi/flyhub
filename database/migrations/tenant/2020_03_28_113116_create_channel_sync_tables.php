<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelSyncTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_syncs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('status')->default('in_queue');
            $table->string('channel');
            $table->string('resource');
            $table->unsignedBigInteger('resource_id')->nullable();
            $table->text('message')->nullable();

            $table->integer('processed')->default(0);
            $table->integer('failed')->default(0);
            $table->integer('total')->default(0);
            $table->integer('current_page')->default(0);
            $table->integer('total_pages')->default(0);

            $table->dateTime('last_received_at')->nullable();

            $table->timestamps();
        });

        Schema::create('channel_sync_results', function (Blueprint $table) {
            $table->id();

            $table->string('status')->nullable()->default('in_queue');
            $table->text('resource_ids')->nullable();

            $table->longText('result')->nullable();
            $table->longText('error')->nullable();
            $table->longText('data')->nullable();

            $table->integer('page')->nullable();
            $table->integer('processed')->nullable();
            $table->integer('failed')->nullable();
            $table->integer('total')->nullable();

            $table->unsignedBigInteger('channel_sync_id');
            $table->foreign('channel_sync_id')->references('id')->on('channel_syncs')->onDelete('cascade');

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
        Schema::dropIfExists('channel_sync_results');
        Schema::dropIfExists('channel_syncs');
    }
}
