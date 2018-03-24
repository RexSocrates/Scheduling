<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropRemarkFromDoctorAndResTable extends Migration
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
            $table->dropColumn('remark');
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
            $table->string('remark', 200)->after('doctorID');
        });
    }
}
