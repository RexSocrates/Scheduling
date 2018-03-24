<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ShiftsPerMonth', function (Blueprint $table) {
            //
            $table->dropColumn('internalShift');
            $table->integer('medicalShift')->after('tamsuiShift');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ShiftsPerMonth', function (Blueprint $table) {
            //
            $table->dropColumn('medicalShift');
            $table->integer('internalShift')->after('tamsuiShift');
        });
    }
}
