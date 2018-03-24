<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropPeriodSerial extends Migration
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
            $table->dropColumn('periodSerial');
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
            $table->integer('periodSerial')->after('resSerial');
        });
    }
}
