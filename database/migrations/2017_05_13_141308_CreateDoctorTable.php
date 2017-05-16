<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // table 5
        Schema::create('Doctor', function (Blueprint $table) {
            $table->increments('doctorID');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('name')->default('');
            $table->string('level')->default('A1');
            $table->string('major')->default('');
            $table->string('location')->default('taipei');
            $table->integer('mustOnDutyTotalShifts')->default(0);
            $table->integer('mustOnDutyInternalShifts')->default(0);
            $table->integer('mustOnDutySurgicalShifts')->default(0);
            $table->integer('mustOnDutyTaipeiShifts')->default(0);
            $table->integer('mustOnDutyTamsuiShifts')->default(0);
            $table->string('identity')->default('general');
            $table->integer('currentOfficialLeaveHours')->nullable();
            $table->integer('currentShiftHours')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('Doctor');
    }
}
