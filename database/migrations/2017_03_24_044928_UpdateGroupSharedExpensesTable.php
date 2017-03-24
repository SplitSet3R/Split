<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupSharedExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groupsharedexpenses', function (Blueprint $table) {
            $table->unique(['group_expense_id', 'username']);

            // Foreign Keys
            $table->foreign('group_expense_id')->references('id')->on('groupexpenses');
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
        Schema::table('groupsharedexpenses', function (Blueprint $table) {
            //
        });
    }
}
