<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateGroupSettledExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groupsettledexpenses', function (Blueprint $table) {
            // Composite Unique Constraint
            $table->unique(['group_shared_expense_id', 'username']);

            // Foreign Keys
            $table->foreign('group_shared_expense_id')->references('id')->on('groupsharedexpenses');
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
        Schema::table('groupsettledexpenses', function (Blueprint $table) {
            //
        });
    }
}
