<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamStaffChosesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_staff_choses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_staff_id', false, true);
            $table->bigInteger('question_id', false, true);
            $table->bigInteger('relies_id', false, true);
            $table->integer('order_question');
            $table->foreign('exam_staff_id')->references('id')->on('exam_staffs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('relies_id')->references('id')->on('relies')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_staff_choses');
    }
}
