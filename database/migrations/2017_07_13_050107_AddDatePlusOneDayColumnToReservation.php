<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatePlusOneDayColumnToReservation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('Reservation', function (Blueprint $table) {
            //
            $table->dropColumn('date');
        });
        
        Schema::table('Reservation', function (Blueprint $table) {
            //
            $table->string('date', 50)->after('isOn');
            $table->string('endDate', 50)->after('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Reservation', function (Blueprint $table) {
            //
            $table->dropColumn(['date', 'endDate']);
        });
        
        Schema::table('Reservation', function (Blueprint $table) {
            //
            $table->date('date')->after('isOn');
        });
    }
}
