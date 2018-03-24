<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDateToShiftsRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ShiftRecords', function (Blueprint $table) {
            //
            $table->string('date', 50)->after('adminConfirm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ShiftRecords', function (Blueprint $table) {
            //
            $table->dropColumn('date');
        });
    }
}
