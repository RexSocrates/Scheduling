<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropLeaveDate extends Migration
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
            $table->dropColumn('leaveDate');
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
            $table->string('leaveDate', 20)->after('updatedLeaveHours');
        });
    }
}
