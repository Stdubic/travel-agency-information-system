<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_units', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('accommodation_object_id')->nullable()->unsigned();
            $table->integer('accommodation_unit_type_id')->nullable()->unsigned();
            $table->integer('basic_bed_number')->nullable();
            $table->integer('additional_bed_number')->nullable();
            $table->string('position')->nullable();
            $table->string('view')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('rating')->nullable();
            $table->string('code')->unique()->nullable();
            $table->boolean('imported')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(0);
            $table->foreign('accommodation_object_id','acc_object_acc_unit_foreign')->references('id')->on('accommodation_objects')->onDelete('cascade');
            $table->foreign('accommodation_unit_type_id','acc_unit_acc_type_foreign')->references('id')->on('accommodation_unit_types')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_units');
    }
}
