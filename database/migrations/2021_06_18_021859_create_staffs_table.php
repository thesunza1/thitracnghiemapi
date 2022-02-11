<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->string('email',60);
            $table->string('password',200);
            $table->string('name',30);
            $table->string('sdt',13);
            $table->string('address',200);
            $table->bigInteger('branch_id')->nullable();
            $table->integer('role_id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null')->onUpdate('cascade');

            $table->foreign('branch_id')->references('id')->on('branchs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staffs');
    }
}
