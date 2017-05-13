<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKPeriodShiftPerMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PeriodShiftPerMonth', function (Blueprint $table) {
            // set composite keys
            $table->primary(['doctorID', 'periodSerial', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('PeriodShiftPerMonth', function (Blueprint $table) {
            //
        });
    }
}
