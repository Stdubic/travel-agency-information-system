<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AccommodationTypeTranslation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_type_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->unique(['accommodation_type_id','locale'], 'acc_types_loc_unique');
            $table->foreign('accommodation_type_id')->references('id')->on('accommodation_types')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_types_translations');
    }
}
