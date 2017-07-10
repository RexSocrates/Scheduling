<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShiftName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->string('shiftName', 20)->after('doctorID');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->dropColumn('shiftName');
        });
    }
}
