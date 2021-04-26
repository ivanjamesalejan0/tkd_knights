<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('member_id');
            $table->dateTime('time_in');
            $table->dateTime('time_out');
            $table->longText('note');
            $table->timestamps();
        });

        Schema::table('attendances', function (Blueprint $table)
        {
            $table->foreign('member_id')->references('id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
}