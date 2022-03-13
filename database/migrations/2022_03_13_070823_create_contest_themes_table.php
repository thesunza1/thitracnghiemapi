<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_themes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contest_id', false, false );
            $table->bigInteger('level_id', false, false );
            $table->bigInteger('theme_id', false, false );
            $table->foreign('contest_id')->references('id')->on('contests')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('theme_id')->references('id')->on('themes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('level_id')->references('id')->on('levels')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('questionnum');
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
        Schema::dropIfExists('contest_themes');
    }
}
