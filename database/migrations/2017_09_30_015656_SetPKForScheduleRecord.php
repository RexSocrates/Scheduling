<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKForScheduleRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ScheduleRecord', function (Blueprint $table) {
            //
            $table->primary(['month', 'doctorID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ScheduleRecord', function (Blueprint $table) {
            //
            $table->dropPrimary('doctorID');
        });
    }
}
