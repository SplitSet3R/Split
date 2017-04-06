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
            // Composite Unique Constraint
            $table->unique(['expense_id', 'secondary_username']);
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
