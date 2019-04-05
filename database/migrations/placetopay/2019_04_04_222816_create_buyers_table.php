<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBuyersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buyers', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('document', 16)->unique();
            $table->string('name', 128);
            $table->string('surname', 128);
            $table->string('email', 32)->unique();
            $table->string('street', 64);
            $table->string('city', 64);
            $table->string('mobile', 30);
            
            $table->integer('document_type_id')->unsigned();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('document_type_id')->references('id')->on('document_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buyers');
    }
}
