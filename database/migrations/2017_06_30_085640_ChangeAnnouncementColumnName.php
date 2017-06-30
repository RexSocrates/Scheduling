<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeAnnouncementColumnName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Announcement', function (Blueprint $table) {
            //
            $table->renameColumn('id', 'announcementSerial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Announcement', function (Blueprint $table) {
            //
            $table->renameColumn('announcementSerial', 'id');
        });
    }
}
