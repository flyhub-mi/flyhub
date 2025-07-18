<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();

            $table->string('state')->nullable();

            $table->boolean('email_sent')->default(false);
            $table->integer('total_qty')->nullable();

            $table->decimal('adjustment_refund', 12, 4)->default(0)->nullable();
            $table->decimal('adjustment_fee', 12, 4)->default(0)->nullable();
            $table->decimal('sub_total', 12, 4)->default(0)->nullable();
            $table->decimal('grand_total', 12, 4)->default(0)->nullable();
            $table->decimal('shipping_amount', 12, 4)->default(0)->nullable();
            $table->decimal('tax_amount', 12, 4)->default(0)->nullable();
            $table->decimal('discount_percent', 12, 4)->default(0)->nullable();
            $table->decimal('discount_amount', 12, 4)->default(0)->nullable();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

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
        Schema::dropIfExists('refunds');
    }
}
