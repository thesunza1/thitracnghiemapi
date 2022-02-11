<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContestSpecialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contest_specials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('contest_id');
            $table->bigInteger('staff_id');
            $table->timestamps();
            $table->foreign('contest_id')->references('id')->on('contests')->onDelete('cascade')->onUpdate('cascade') ;
            $table->foreign('staff_id')->references('id')->on('staffs')->onDelete('cascade')->onUpdate('cascade') ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contest_specials');
    }
}
