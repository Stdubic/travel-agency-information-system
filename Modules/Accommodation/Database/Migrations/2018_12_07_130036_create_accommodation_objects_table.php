<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccommodationObjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_objects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type');
            $table->integer('country_id')->unsigned();
            $table->integer('region_id')->unsigned();
            $table->integer('city_id')->unsigned();
            $table->integer('supplier_id')->unsigned();
            $table->string('tel_num');
            $table->string('reception_email');
            $table->string('booking_email');
            $table->string('office_phone');
            $table->string('website');
            $table->string('address');
            $table->string('time_zone');
            $table->string('currency');
            $table->string('bank_name');
            $table->string('bank_office');
            $table->string('bank_swift');
            $table->string('account_number');
            $table->string('company_name');
            $table->string('bank_iban');
            $table->string('contact_person');
            $table->integer('added_tax');
            $table->integer('office_tax');
            $table->integer('rating');
            $table->string('channel_manager')->nullable();
            $table->string('channel_manager_code')->nullable()->unique();
            $table->decimal('long', 10, 7);
            $table->decimal('lat', 10, 7);
            $table->boolean('is_synced')->default(0);
            //$table->foreign('type_id','type_id_foreign')->references('id')->on('accommodation_types')->onDelete('cascade');
            $table->foreign('country_id','country_id_foreign')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('region_id','region_id_foreign')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('city_id','city_id_foreign')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('supplier_id','supplier_id_foreign')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('accommodation_objects');
    }
}
