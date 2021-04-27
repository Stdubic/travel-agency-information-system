<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNaturalUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('natural_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->bigInteger('id_num')->nullable();
            $table->date('birth_date');
            $table->bigInteger('passport_num')->nullable();
            $table->date('passport_issued_at')->nullable();
            $table->date('passport_expired_at')->nullable();
            $table->string('nationality');
            $table->enum('sex', ['m', 'f']);
            $table->string('website')->nullable();
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
        Schema::dropIfExists('natural_users');
    }
}
