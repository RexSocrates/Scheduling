<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExclusiveMajor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ScheduleCategory', function (Blueprint $table) {
            //
            $table->string('location')->after('schCategoryName');
            $table->string('exclusiveMajor')->after('location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ScheduleCategory', function (Blueprint $table) {
            //
            $table->dropColumn('location');
            $table->dropColumn('exclusiveMajor');
        });
    }
}
