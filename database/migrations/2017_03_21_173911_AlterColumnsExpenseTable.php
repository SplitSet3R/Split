<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterColumnsExpenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement('ALTER TABLE `expenses` MODIFY `comments` VARCHAR(255) NULL;');
        DB::statement('ALTER TABLE `expenses` MODIFY `date_added` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
