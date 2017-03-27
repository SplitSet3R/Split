<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recipient_username');
            $table->string('sender_username');
            $table->smallInteger('category');
            $table->smallInteger('type');
            $table->string('parameters');
            $table->boolean('is_read')->default(0);
            $table->integer('reference_id');
            $table->timestamp('date_added');
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
