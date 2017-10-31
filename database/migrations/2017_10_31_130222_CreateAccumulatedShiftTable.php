<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccumulatedShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('AccumulatedShift', function (Blueprint $table) {
            $table->integer('doctorID');
            // 此日期格式為2017-09
            $table->string('month');
            // 當月上班表上的班
            $table->integer('shifts');
            // 累積的積欠班
            $table->integer('accumulatedShift');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('AccumulatedShift');
    }
}
