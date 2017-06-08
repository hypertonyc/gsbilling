<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingDevicesTabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billingdevices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('billingclient_id')->unsigned();
            $table->string('imei');
            $table->string('number');
            $table->timestamp('last_date')->nullable();
            $table->boolean('is_free');
            $table->decimal('amount', 7, 2)->default(0.0);
            $table->foreign('billingclient_id')->references('id')->on('billingclients');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billingdevices');
    }
}
