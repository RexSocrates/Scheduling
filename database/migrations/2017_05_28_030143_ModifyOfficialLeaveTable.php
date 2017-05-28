<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyOfficialLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('OfficialLeave', function (Blueprint $table) {
            //
            $table->dropColumn('confirmingPersonID', 'recordDate');
        });
        
        Schema::table('OfficialLeave', function (Blueprint $table) {
            //
            $table->integer('confirmingPersonID')->nullable()->default(0)->after('doctorID');
            $table->string('recordDate')->after('leaveHours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('OfficialLeave', function (Blueprint $table) {
            //
            $table->dropColumn('confirmingPersonID', 'recordDate');
        });
        
        Schema::table('OfficialLeave', function (Blueprint $table) {
            //
            $table->integer('confirmingPersonID')->after('doctorID');
            $table->date('recordDate')->after('leaveHours');
        });
    }
}
