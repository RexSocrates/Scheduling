<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeriodShiftPerMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // table 10
        Schema::create('PeriodShiftPerMonth', function (Blueprint $table) {
            $table->integer('doctorID');
            $table->integer('periodSerial');
            $table->date('date');
            $table->integer('shifts');
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
        Schema::dropIfExists('PeriodShiftPerMonth');
    }
}
