<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // table 3
        Schema::create('ShiftRecords', function (Blueprint $table) {
            $table->bigIncrements('changeSerial');
            $table->bigInteger('scheduleID_1')->default(0);
            $table->bigInteger('scheduleID_2')->default(0);
            $table->integer('schID_1_doctor')->default(0);
            $table->integer('schID_2_doctor')->default(0);
            $table->boolean('doc2Confirm')->nullable();
            $table->boolean('adminConfirm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ShiftRecords');
    }
}
