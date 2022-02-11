<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contest_id',false,true)->nullable();
            $table->bigInteger('issuer_id',false,true)->nullable();
            $table->integer('questionNum',false,true)->default(0);
            $table->integer('questionMix',false,true)->default(0);
            $table->integer('RelyMix',false,true)->default(0);
            $table->integer('examTime_at');
            $table->timestamp('created_at');
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('issuer_id')->references('id')->on('staffs')->onDelete('set null')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exams');
    }
}
