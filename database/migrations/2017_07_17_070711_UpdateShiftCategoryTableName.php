<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateShiftCategoryTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('CreateShiftCategory');
        
        Schema::create('ShiftCategory', function (Blueprint $table) {
            $table->increments('categorySerial');
            $table->string('categoryName', 20);
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
        Schema::dropIfExists('ShiftCategory');
        
        Schema::create('CreateShiftCategory', function (Blueprint $table) {
            $table->increments('categorySerial');
            $table->string('categoryName', 20);
            $table->timestamps();
        });
    }
}
