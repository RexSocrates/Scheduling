<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOnDutyShiftPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // table 8
        Schema::create('OnDutyShiftPeriod', function (Blueprint $table) {
            $table->integer('doctorID');
            $table->integer('periodSerial');
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
        Schema::dropIfExists('OnDutyShiftPeriod');
    }
}
