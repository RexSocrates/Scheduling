<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPwdToDoctorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Doctor', function (Blueprint $table) {
            // 修改Doctor 中的屬性設定，以及加入新屬性
            DB::statement("ALTER TABLE `Doctor` ADD `password` VARCHAR(191) NOT NULL AFTER `email`");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Doctor', function (Blueprint $table) {
            //
        });
    }
}
