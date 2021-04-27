<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationUnitTypeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_unit_type_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_unit_type_id')->unsigned();
            $table->string('title');
            $table->string('locale')->index();
            $table->unique(['accommodation_unit_type_id','locale'], 'acc_un_types_loc_unique');
            $table->foreign('accommodation_unit_type_id', 'acc_unit_trans_foreign')->references('id')->on('accommodation_unit_types')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_unit_type_translations');
    }
}
