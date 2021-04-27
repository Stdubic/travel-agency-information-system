<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationObjectAmenitySetPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_object_amenity_set_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_id')->unsigned();
            $table->integer('amenity_set_id')->unsigned();
            $table->foreign('accommodation_object_id','acc_obj_am_set_foreign')->references('id')->on('accommodation_objects')->onDelete('cascade');
            $table->foreign('amenity_set_id','am_set_id_acc_obj_foreign')->references('id')->on('amenity_sets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_object_amenity_set_pivot');
    }
}
