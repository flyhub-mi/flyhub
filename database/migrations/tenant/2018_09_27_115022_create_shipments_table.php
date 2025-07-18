<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShipmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();

            $table->string('carrier')->nullable();
            $table->string('method')->nullable();
            $table->string('track_number')->nullable();
            $table->boolean('email_sent')->default(false);
            $table->decimal('price', 12, 4)->default(0);
            $table->double('weight')->nullable();
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->double('depth')->nullable();

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');

            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            $table->unsignedBigInteger('inventory_source_id')->nullable();
            $table->foreign('inventory_source_id')->references('id')->on('inventory_sources')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipments');
    }
}
