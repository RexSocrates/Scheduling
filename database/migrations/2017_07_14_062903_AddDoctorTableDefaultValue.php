<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDoctorTableDefaultValue extends Migration
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
            $table->dropColumn(['currentOfficialLeaveHours', 'currentShiftHours']);
        });
        
        Schema::table('Doctor', function (Blueprint $table) {
            //
            $table->integer('currentOfficialLeaveHours')->default(0)->after('mustOnDutyNightShifts');
            $table->integer('currentShiftHours')->default(0)->after('currentOfficialLeaveHours');
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
            $table->dropColumn(['currentOfficialLeaveHours', 'currentShiftHours']);
        });
        
        Schema::table('Doctor', function (Blueprint $table) {
            //
            $table->integer('currentOfficialLeaveHours')->after('identity');
            $table->integer('currentShiftHours')->after('currentOfficialLeaveHours');
        });
    }
}
