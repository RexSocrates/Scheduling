<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarkToDoctorAndReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('DoctorAndReservation', function (Blueprint $table) {
            //
            $table->string('remark', 200)->nullable()->after('doctorID');
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
            $table->dropColumn('remark');
        });
    }
}
