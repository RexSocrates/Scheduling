<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDataType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ShiftRecords', function (Blueprint $table) {
            // 將醫生2確認以及排班人員確認的資料型態改為integer
            
            DB::statement('ALTER TABLE `ShiftRecords` DROP `doc2Confirm`,DROP `adminConfirm`');
            
            DB::statement('ALTER TABLE `ShiftRecords` ADD `doc2Confirm` INT NULL AFTER `schID_2_doctor`, ADD `adminConfirm` INT NULL AFTER `doc2Confirm`');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ShiftRecords', function (Blueprint $table) {
            //
            DB::statement('ALTER TABLE `ShiftRecords` DROP `doc2Confirm`,DROP `adminConfirm`');
            
            DB::statement('ALTER TABLE `ShiftRecords` ADD `doc2Confirm` BOOLEAN NULL AFTER `schID_2_doctor`, ADD `adminConfirm` BOOLEAN NULL AFTER `doc2Confirm`');
        });
    }
}
