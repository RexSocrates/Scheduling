<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeletePeriodSerial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->dropColumn('periodSerial');
        });
        
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->integer('categorySerial')->after('shiftName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->dropColumn('categorySerial');
        });
        
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->integer('periodSerial')->after('shiftName');
        });
    }
}
