<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccommodationObjectCategoryPivot extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_object_category_pivot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_id')->unsigned();
            $table->integer('accommodation_category_id')->unsigned();
            $table->foreign('accommodation_object_id','acc_object_id_cat_foreign')->references('id')->on('accommodation_objects')->onDelete('cascade');
            $table->foreign('accommodation_category_id','acc_cat_id_obj_foreign')->references('id')->on('accommodation_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_object_category_pivot');
    }
}
