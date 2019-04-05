<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpirationDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expiration_dates', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->dateTime('expires_at');

            $table->bigInteger('payment_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_id')->references('id')->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expiration_dates');
    }
}
