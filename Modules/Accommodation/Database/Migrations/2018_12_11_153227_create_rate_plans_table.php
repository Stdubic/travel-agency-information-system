<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accommodation_object_id')->unsigned();
            $table->string('code')->nullable()->unique();
            $table->string('name');
            $table->string('service')->nullable(); //enum
            $table->string('type')->nullable(); //enum
            $table->string('base_price')->nullable();
            $table->string('b2c_margin_type')->nullable(); //percent or fixed
            $table->string('b2c_margin')->nullable(); //percent or fixed
            $table->integer('min_person')->nullable();
            $table->integer('min_stay')->nullable();
            $table->integer('max_stay')->nullable();
            $table->integer('release_period')->nullable();
            $table->boolean('sojourn_tax')->nullable()->default(0);
            $table->string('currency')->nullable();
            $table->date('start')->nullable();
            $table->date('stop')->nullable();
            $table->boolean('imported')->nullable()->default(0);
            $table->foreign('accommodation_object_id','acc_object_rate_plan_foreign')->references('id')->on('accommodation_objects')->onDelete('cascade');
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
        Schema::dropIfExists('rate_plans');
    }
}
