<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficialLeaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // table 9
        Schema::create('OfficialLeave', function (Blueprint $table) {
            $table->bigIncrements('leaveSerial');
            $table->integer('doctorID');
            $table->date('recordDate');
            $table->string('remark')->nullable();
            $table->integer('confirmStatus')->default(0);
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
        Schema::dropIfExists('OfficialLeave');
    }
}
