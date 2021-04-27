<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationCategoryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_category_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_category_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->unique(['accommodation_category_id','locale'], 'acc_cat_loc_unique');
            $table->foreign('accommodation_category_id','acc_cat_foreign')->references('id')->on('accommodation_categories')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_category_translations');
    }
}
