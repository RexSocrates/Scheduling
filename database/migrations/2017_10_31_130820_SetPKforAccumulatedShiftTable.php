<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKforAccumulatedShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('AccumulatedShift', function (Blueprint $table) {
            //
            $table->primary(['doctorID', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('AccumulatedShift', function (Blueprint $table) {
            //
            $table->dropPrimary('month');
        });
    }
}
