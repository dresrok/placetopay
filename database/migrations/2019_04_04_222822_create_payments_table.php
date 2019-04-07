<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('reference', 32)->unique();
            $table->string('description', 128);
            $table->string('currency', 8);
            $table->double('total', 12, 2);
            $table->boolean('allow_partial')->default(0);
            $table->boolean('redirected')->default(0);

            $table->bigInteger('buyer_id')->unsigned()->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('buyer_id')->references('id')->on('buyers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
