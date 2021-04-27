<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenitySetTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenity_set_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amenity_set_id')->unsigned();
            $table->string('title');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['amenity_set_id','locale'], 'amenity_set_loc_unique');
            $table->foreign('amenity_set_id','amenity_set_foreign')->references('id')->on('amenity_sets')->onDelete('cascade');
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
        Schema::dropIfExists('amenity_set_translations');
    }
}
