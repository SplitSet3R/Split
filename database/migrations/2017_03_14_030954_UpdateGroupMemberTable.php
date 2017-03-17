<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groupmembers', function (Blueprint $table) {
            // Primary Key
            $table->primary(array('group_id', 'username'));

            // Foreign Keys
            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('username')->references('username')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('groupmembers', function (Blueprint $table) {
            //
        });
    }
}
