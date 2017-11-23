<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeLeaveMonthNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('OfficialLeave', function (Blueprint $table) {
            //
            $table->string('leaveMonth', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('OfficialLeave', function (Blueprint $table) {
            //
            $table->string('leaveMonth', 20)->change();
        });
    }
}
