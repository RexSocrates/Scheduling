<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKDoctorAndReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('DoctorAndReservation', function (Blueprint $table) {
            // set composite keys
            $table->primary(['resSerial', 'doctorID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('DoctorAndReservation', function (Blueprint $table) {
            //
        });
    }
}
