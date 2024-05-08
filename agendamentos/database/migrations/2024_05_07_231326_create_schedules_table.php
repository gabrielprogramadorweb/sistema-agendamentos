<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
        public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('service_id');
            $table->integer('month');
            $table->integer('day');
            $table->string('hour');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

        public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'user_name', 'user_email', 'user_phone']);
        });
    }

};
