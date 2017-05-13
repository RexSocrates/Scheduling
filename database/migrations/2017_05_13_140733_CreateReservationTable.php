<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // table 1
        Schema::create('Reservation', function (Blueprint $table) {
            $table->bigIncrements('resSerial');
            $table->integer('periodSerial')->default(0);
            $table->boolean('isWeekday')->default(true);
            $table->string('location')->default('');
            $table->boolean('isOn')->default(true);
            $table->date('date');
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('Reservation');
    }
}
