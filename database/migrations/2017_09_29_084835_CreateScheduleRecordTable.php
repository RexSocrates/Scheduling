<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ScheduleRecord', function (Blueprint $table) {
            // 記錄每個醫生每個月欠班的狀況
            $table->string('month', 20);
            $table->integer('doctorID');
            $table->integer('shiftHours');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ScheduleRecord');
    }
}
