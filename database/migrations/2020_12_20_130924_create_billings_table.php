<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table)
        {
            $table->increments('id');
            $table->integer('member_id');
            $table->string('membership_type', 50);
            $table->float('membership_fee', 8, 2);
            $table->string('payment_type', 50);
            $table->float('amount', 8, 2);
            $table->float('balance', 8, 2);
            $table->string('payment_token', 500);
            $table->longText('payment_error');
            $table->longText('note');
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
        Schema::dropIfExists('billings');
    }
}