<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('firstname', 50);
            $table->string('middlename', 50);
            $table->string('lastname', 50);
            $table->string('image', 250);
            $table->date('dob');
            $table->string('gender', 50);
            $table->string('civil_status', 50);
            $table->string('citizenship', 50);
            $table->string('contact', 50);
            $table->string('email', 50);
            $table->string('id_type', 50);
            $table->string('id_number', 50);
            $table->string('emergency_person', 100);
            $table->string('emergency_contact', 50);
            $table->string('emergency_relationship', 50);
            $table->integer('referrer');
            $table->string('membership_status', 50);
            $table->date('date_started');
            $table->date('date_restarted');
            $table->string('membership_type', 50);
            $table->longText('billing_address');
            $table->longText('home_address');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}