<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSettledExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settledexpenses', function (Blueprint $table) {
            // Primary keys
            $table->primary('expense_id', 'secondary_username');

            // Foreign keys
            $table->foreign('expense_id')->references('expense_id')->on('sharedexpenses');
            $table->foreign('secondary_username')->references('secondary_username')->on('sharedexpenses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settledexpenses', function (Blueprint $table) {
            //
        });
    }
}
