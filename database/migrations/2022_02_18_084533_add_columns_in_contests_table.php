<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contests', function (Blueprint $table) {
            //
            $table->integer('auto_make_exam')->default(0);
            $table->integer('relymix')->default(0);
            $table->integer('questionmix')->default(0);
            $table->timestamp('date_limit')->nullable();
            $table->integer('num_date_create')->default(0);
            $table->integer('time_create')->nullable();
            $table->timestamp('last_create')->nullable();
            $table->integer('examtime_at')->default(0);
            $table->integer('examcan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contests', function (Blueprint $table) {
            //
        });
    }
}
