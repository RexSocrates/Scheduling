<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDatePlusOneDayColumnToSchedule extends Migration
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
            $table->dropColumn('date');
        });
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->string('date', 50)->after('category');
            $table->string('endDate', 50)->after('date');
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
            $table->dropColumn(['date', 'endDate']);
        });
        Schema::table('Schedule', function (Blueprint $table) {
            //
            $table->date('date')->after('category');
        });
    }
}
