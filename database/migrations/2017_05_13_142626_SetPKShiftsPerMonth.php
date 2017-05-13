<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKShiftsPerMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ShiftsPerMonth', function (Blueprint $table) {
            // set composite keys
            $table->primary(['doctorID', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ShiftsPerMonth', function (Blueprint $table) {
            //
        });
    }
}
