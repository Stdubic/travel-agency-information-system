<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatePeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_periods', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rate_id')->unsigned();
            $table->date('period');
            $table->decimal('price');
            $table->integer('rooms_to_sell');
            $table->integer('minimum_stay');
            $table->foreign('rate_id','rate_id_foreign')->references('id')->on('rate_plans')->onDelete('cascade');
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
        Schema::dropIfExists('rate_periods');
    }
}
