<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomRateUnitPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_rate_unit_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rate_plan_id')->unsigned();
            $table->integer('accommodation_unit_id')->unsigned();
            $table->foreign('rate_plan_id','rate_plan_id_unit_foreign')->references('id')->on('rate_plans')->onDelete('cascade');
            $table->foreign('accommodation_unit_id','acc_unit_id_rate_foreign')->references('id')->on('accommodation_units')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('room_rate_unit_pivot');
    }
}
