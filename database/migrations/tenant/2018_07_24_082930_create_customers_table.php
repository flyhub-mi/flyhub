<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('cpf_cnpj')->nullable()->index();
            $table->string('ie')->nullable();
            $table->string('rg')->nullable();

            $table->string('gender')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('email');
            $table->boolean('status')->default(true);
            $table->boolean('subscribed_to_news_letter')->default(false);
            $table->string('phone')->nullable();
            $table->string('cellphone')->nullable();
            $table->text('notes')->nullable();

            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('restrict');
            $table->string('remote_id')->nullable();

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
        Schema::dropIfExists('customers');
    }
}
