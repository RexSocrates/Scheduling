<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDoctorTable extends Migration
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
            $table->dropColumn('mustOnDutyTotalShifts');
            $table->dropColumn('mustOnDutyInternalShifts');
            $table->dropColumn('mustOnDutySurgicalShifts');
            $table->dropColumn('mustOnDutyTaipeiShifts');
            $table->dropColumn('mustOnDutyTamsuiShifts');
        });
        
        
        
        Schema::table('Doctor', function (Blueprint $table) {
            //
            $table->integer('mustOnDutyTotalShifts')->nullable()->default(0);
            $table->integer('mustOnDutyInternalShifts')->nullable()->default(0);
            $table->integer('mustOnDutySurgicalShifts')->nullable()->default(0);
            $table->integer('mustOnDutyTaipeiShifts')->nullable()->default(0);
            $table->integer('mustOnDutyTamsuiShifts')->nullable()->default(0);
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
        });
    }
}
