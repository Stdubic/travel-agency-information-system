<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationObjectDescriptionTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_object_description_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_id')->unsigned();
            $table->string('description');
            $table->string('locale')->index();
            $table->unique(['accommodation_object_id','locale'], 'acc_obj_desc_loc_unique');
            $table->foreign('accommodation_object_id', 'acc_obj_des_trans_foreign')->references('id')->on('accommodation_objects')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_object_description_translations');
    }
}
