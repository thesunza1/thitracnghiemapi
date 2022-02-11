<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('name',60);
            $table->bigInteger('testMaker_id',false,true)->nullable();
            $table->bigInteger('branchContest_id',false,true)->nullable();
            $table->text('content')->nullable();
            $table->timestamp('beginTime_at');
            $table->timestamp('created_at');
            $table->foreign('testMaker_id')->references('id')->on('staffs')->onDelete('set null')->onUpdate('cascade');
            $table->foreign('branchContest_id')->references('id')->on('branchs')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contests');
    }
}
