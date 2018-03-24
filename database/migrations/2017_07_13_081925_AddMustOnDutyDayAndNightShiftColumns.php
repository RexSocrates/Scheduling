<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMustOnDutyDayAndNightShiftColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Doctor', function (Blueprint $table) {
            //
            $table->integer('mustOnDutyDayShifts')->after('mustOnDutyTamsuiShifts')->default(0);
            $table->integer('mustOnDutyNightShifts')->after('mustOnDutyDayShifts')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Doctor', function (Blueprint $table) {
            //
            $table->dropColumn(['mustOnDutyDayShifts', 'mustOnDutyNightShifts']);
        });
    }
}
