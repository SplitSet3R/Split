<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettledExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settledexpenses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('expense_id');
            $table->float('amount_owed');
            $table->string('secondary_username');
            $table->string('comments');
            $table->date('date_added');
            $table->date('date_settled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settledexpenses');
    }
}
