<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClassAttendace extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classAttendance',function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('class_content');
            $table->foreign('class_content')->references('id')->on('classContent');
            $table->text('contents');
            $table->unsignedInteger('member');
            $table->foreign('member')->references('id')->on('classMember');
            $table->date('date');
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
        Schema::drop('classAttendance');
    }
}
