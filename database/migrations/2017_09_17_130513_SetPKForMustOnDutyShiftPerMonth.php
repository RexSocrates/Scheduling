<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetPKForMustOnDutyShiftPerMonth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('MustOnDutyShiftPerMonth', function (Blueprint $table) {
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
        Schema::table('MustOnDutyShiftPerMonth', function (Blueprint $table) {
            // 最少要留下一個pk，否則會出錯
            $table->dropPrimary('month');
        });
    }
}
