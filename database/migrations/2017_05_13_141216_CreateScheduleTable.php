<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // table 4
        Schema::create('Schedule', function (Blueprint $table) {
            $table->bigIncrements('scheduleID');
            $table->integer('doctorID');
            $table->integer('periodSerial')->default(0);
            $table->boolean('isWeekday')->default(true);
            $table->string('location')->default('taipei');
            $table->string('category')->default('');
            $table->date('date');
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
        Schema::dropIfExists('Schedule');
    }
}
