<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQueRelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_que_rels', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('exam_staff_id');
            $table->bigInteger('question_id');
            $table->bigInteger('order_question');
            $table->bigInteger('relies_id');
            $table->bigInteger('order_relies');
            $table->bigInteger('chose')->default(-1);
            $table->foreign('exam_staff_id')->references('id')->on('exam_staffs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('relies_id')->references('id')->on('relies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_que_rels');
    }
}
