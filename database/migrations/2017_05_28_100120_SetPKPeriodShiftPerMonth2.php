<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKPeriodShiftPerMonth2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('PeriodShiftPerMonth', function (Blueprint $table) {
            //
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
