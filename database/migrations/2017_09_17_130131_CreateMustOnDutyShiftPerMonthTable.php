<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMustOnDutyShiftPerMonthTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('MustOnDutyShiftPerMonth', function (Blueprint $table) {
            // pk
            $table->integer('doctorID');
            $table->string('month', 20);
            
            // 記錄扣除公假後每個月的每一位醫師應該上班的總班數
            $table->integer('mustOnDutyShift');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('MustOnDutyShiftPerMonth');
    }
}
