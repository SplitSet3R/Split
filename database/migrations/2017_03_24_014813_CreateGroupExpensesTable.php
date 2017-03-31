<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupexpenses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id');
            $table->float('amount');
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
        Schema::dropIfExists('groupexpenses');
    }
}
