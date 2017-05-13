<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKOnDutyShiftPeriod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('OnDutyShiftPeriod', function (Blueprint $table) {
            // set composite keys
            $table->primary(['doctorID', 'periodSerial']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('OnDutyShiftPeriod', function (Blueprint $table) {
            //
        });
    }
}
