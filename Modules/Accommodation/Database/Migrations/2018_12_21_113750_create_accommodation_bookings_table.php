<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_id')->unsigned();
            $table->integer('accommodation_unit_id')->unsigned();
            $table->integer('rate_plan_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->text('guests')->nullable();
            $table->date('start');
            $table->date('end');
            $table->string('status');
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
        Schema::dropIfExists('accommodation_bookings');
    }
}
