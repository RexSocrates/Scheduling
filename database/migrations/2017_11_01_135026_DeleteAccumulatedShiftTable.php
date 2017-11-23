<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteAccumulatedShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('AccumulatedShift');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::create('AccumulatedShift', function (Blueprint $table) {
            $table->integer('doctorID');
            // 此日期格式為2017-09
            $table->string('month');
            // 當月上班表上的班
            $table->integer('shifts');
            // 累積的積欠班
            $table->integer('accumulatedShift');
        });
        
        Schema::table('AccumulatedShift', function (Blueprint $table) {
            //
            $table->primary(['doctorID', 'month']);
        });
    }
}
