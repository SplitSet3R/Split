<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupSharedExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupsharedexpenses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_expense_id');
            $table->string('username');
            $table->float('amount_owed');
            $table->string('comments');
            $table->date('date_added');
            $table->date('date_settled')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupsharedexpenses');
    }
}
