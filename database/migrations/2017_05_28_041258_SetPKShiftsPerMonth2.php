<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKShiftsPerMonth2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ShiftsPerMonth', function (Blueprint $table) {
            //
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
