<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLeaveHours extends Migration
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
            $table->integer('confirmingPersonID')->after('doctorID');
            $table->integer('leaveHours')->after('confirmingPersonID');
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
            $table->dropColumn('confirmingPersonID');
            $table->dropColumn('leaveHours');
        });
    }
}
