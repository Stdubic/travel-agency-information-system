<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_types', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('standard_capacity');
            $table->integer('max_capacity');
            $table->integer('min_capacity');
            $table->integer('max_adults');
            $table->integer('min_children');
            $table->tinyInteger('description');
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
        Schema::dropIfExists('accommodation_types');
    }
}
