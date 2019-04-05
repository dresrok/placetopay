<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_references', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('process_url', 256);
            $table->bigInteger('request_id')->unsigned();

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
        Schema::dropIfExists('payment_references');
    }
}
