<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payment', function (Blueprint $table) {
            $table->id();

            $table->string('status')->nullable();
            $table->string('method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->integer('installments')->default(0);
            $table->decimal('total_paid', 12, 4)->default(0)->nullable();
            $table->string('notes')->nullable();
            $table->date('issued_date')->nullable();
            $table->date('due_date')->nullable();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_payment');
    }
}
