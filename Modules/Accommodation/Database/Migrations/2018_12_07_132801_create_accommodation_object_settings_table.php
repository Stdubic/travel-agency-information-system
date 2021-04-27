<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationObjectSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_object_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_id')->unsigned();
            $table->boolean('sojourn_tax')->default(0);
            $table->boolean('front_visibility')->default(0);
            $table->boolean('admin_visibility')->default(0);
            $table->boolean('recommendation')->default(0);
            $table->boolean('rating')->default(0);
            $table->boolean('medical')->default(0);
            $table->boolean('household')->default(0);
            $table->foreign('accommodation_object_id','acc_object_id_foreign')->references('id')->on('accommodation_objects')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_object_settings');
    }
}
