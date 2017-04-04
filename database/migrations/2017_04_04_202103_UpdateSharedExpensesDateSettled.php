<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSharedExpensesDateSettled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('sharedexpenses', function (Blueprint $table) {
          $table->dropColumn(['date_added', 'date_settled']);

      });

      Schema::table('sharedexpenses', function (Blueprint $table) {
          $table->timestamp('date_added');
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
        //
    }
}
