<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->text('content');
            $table->bigInteger('level_id',false,true)->nullable();
            $table->bigInteger('theme_id',false,true)->nullable();
            $table->bigInteger('staffCreated_id',false,true)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
            $table->foreign('theme_id')->references('id')->on('themes')->onDelete('set null');
            $table->foreign('staffCreated_id')->references('id')->on('staffs')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
