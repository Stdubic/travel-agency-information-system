<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationObjectImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_object_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_id')->unsigned()->nullable();
            $table->integer('unique_id');
            $table->foreign('accommodation_object_id','acc_obj_image_foreign')->references('id')->on('accommodation_objects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_object_images');
    }
}
