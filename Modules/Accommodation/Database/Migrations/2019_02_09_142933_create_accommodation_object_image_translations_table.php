<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationObjectImageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_object_image_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_image_id')->unsigned();
            $table->string('alt');
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['accommodation_object_image_id','locale'], 'acc_obj_img_loc_unique');
            $table->foreign('accommodation_object_image_id', 'acc_obj_img_trans_foreign')->references('id')->on('accommodation_object_images')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodation_object_image_translations');
    }
}
