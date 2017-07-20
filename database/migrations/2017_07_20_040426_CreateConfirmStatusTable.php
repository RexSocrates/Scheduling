<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('LeaveConfirmStatus');
        
        Schema::create('ConfirmStatus', function (Blueprint $table) {
            $table->integer('confirmSerial');
            $table->string('status');
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
        Schema::dropIfExists('ConfirmStatus');
        
        Schema::create('LeaveConfirmStatus', function (Blueprint $table) {
            $table->integer('confirmSerial');
            $table->string('status');
            $table->timestamps();
        });
    }
}
