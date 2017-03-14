<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSharedExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sharedexpenses', function (Blueprint $table) {
            // Primary keys
            $table->primary('expense_id', 'secondary_username');

            // Foreign keys
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->foreign('secondary_username')->references('username')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sharedexpenses', function (Blueprint $table) {
            //
        });
    }
}
