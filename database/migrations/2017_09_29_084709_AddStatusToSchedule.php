<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Schedule', function (Blueprint $table) {
            // 換班後在scheduler用不同顏色顯示
            $table->integer('status')->after('confirmed')->nullable();
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
            $table->dropColumn('status');
        });
    }
}
