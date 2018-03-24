<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToDoctor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Doctor', function (Blueprint $table) {
            // 原始總班數，包含行政與教學班
            $table->integer('totalShift')->default(15)->after('updated_at');
            // 紀錄假日班數
            $table->integer('weekendShifts')->after('mustOnDutyNightShifts');
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
            $table->dropColumn(['totalShift', 'weekendShifts']);
        });
    }
}
