<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmenityTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amenity_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amenity_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->unique(['amenity_id','locale'], 'amenity_loc_unique');
            $table->foreign('amenity_id','amenity_translation_foreign')->references('id')->on('amenities')->onDelete('cascade');
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
        Schema::dropIfExists('amenity_translations');
    }
}
