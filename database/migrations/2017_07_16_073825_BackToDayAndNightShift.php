<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BackToDayAndNightShift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //drop Period, OnDutyShiftPeriod and PeriodShiftPerMonth table
        Schema::dropIfExists('Period');
        Schema::dropIfExists('OnDutyShiftPeriod');
        Schema::dropIfExists('PeriodShiftPerMonth');
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Period
        Schema::create('Period', function (Blueprint $table) {
            $table->increments('periodSerial');
            $table->string('periodName');
            $table->date('startingTime');
            $table->date('endTime');
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
        
        // OnDutyShiftPeriod
        Schema::create('OnDutyShiftPeriod', function (Blueprint $table) {
            $table->integer('doctorID');
            $table->integer('periodSerial');
            $table->integer('shifts');
            $table->timestamps();
        });
        
        Schema::table('OnDutyShiftPeriod', function (Blueprint $table) {
            // set composite keys
            $table->primary(['doctorID', 'periodSerial']);
        });
        
        // PeriodShiftPerMonth
        Schema::create('PeriodShiftPerMonth', function (Blueprint $table) {
            $table->integer('doctorID');
            $table->integer('periodSerial');
            $table->date('date');
            $table->integer('shifts');
            $table->timestamps();
        });
        
        Schema::table('PeriodShiftPerMonth', function (Blueprint $table) {
            // set composite keys
            $table->primary(['doctorID', 'periodSerial', 'date']);
        });
    }
}
