<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnSchedule extends Migration
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
            DB::statement('ALTER TABLE `Schedule` ADD `confirmed` BOOLEAN NULL AFTER `date`');
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
            $table->dropColumn('confirmed');
        });
    }
}
