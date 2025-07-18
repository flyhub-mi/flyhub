<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('channel_name')->nullable();
            $table->string('remote_id')->nullable();

            $table->boolean('is_guest')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_name');

            $table->string('note')->nullable();
            $table->string('private_note')->nullable();
            $table->date('issued_date')->nullable();

            $table->string('shipping_method')->nullable();
            $table->string('coupon_code')->nullable();
            $table->boolean('is_gift')->default(false);

            $table->integer('total_item_count')->nullable();
            $table->integer('total_qty_ordered')->nullable();

            $table->decimal('grand_total', 12, 4)->default(0)->nullable();
            $table->decimal('grand_total_invoiced', 12, 4)->default(0)->nullable();
            $table->decimal('grand_total_refunded', 12, 4)->default(0)->nullable();

            $table->decimal('sub_total', 12, 4)->default(0)->nullable();
            $table->decimal('sub_total_invoiced', 12, 4)->default(0)->nullable();
            $table->decimal('sub_total_refunded', 12, 4)->default(0)->nullable();

            $table->decimal('discount_percent', 12, 4)->default(0)->nullable();
            $table->decimal('discount_amount', 12, 4)->default(0)->nullable();
            $table->decimal('discount_invoiced', 12, 4)->default(0)->nullable();
            $table->decimal('discount_refunded', 12, 4)->default(0)->nullable();

            $table->decimal('tax_amount', 12, 4)->default(0)->nullable();
            $table->decimal('tax_amount_invoiced', 12, 4)->default(0)->nullable();
            $table->decimal('tax_amount_refunded', 12, 4)->default(0)->nullable();

            $table->decimal('shipping_amount', 12, 4)->default(0)->nullable();
            $table->decimal('shipping_invoiced', 12, 4)->default(0)->nullable();
            $table->decimal('shipping_refunded', 12, 4)->default(0)->nullable();

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');

            $table->unsignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('set null');

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
        Schema::dropIfExists('orders');
    }
}
