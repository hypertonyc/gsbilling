<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingClientsTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billingclients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billing_id')->unsigned();
            $table->string('name');
            $table->decimal('price', 7, 2);
            $table->decimal('balance', 10, 2);            
            $table->foreign('billing_id')->references('id')->on('billings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billingclients');
    }
}
