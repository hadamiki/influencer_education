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
        Schema::create('delivery_times', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('curriculums_id');

            $table->dateTime('delivery_from')->nullable();
            $table->dateTime('delivery_to')->nullable();
            $table->timestamps();


            // 外部キー
            $table->foreign('curriculums_id')->references('id')->on('curriculums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_times');
    }
};
