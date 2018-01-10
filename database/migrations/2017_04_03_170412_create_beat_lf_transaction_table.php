<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeatLfTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beat_lf_transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('beat_id')->unsigned();
            $table->foreign('beat_id')->references('id')->on('beats')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('lf_transaction_id')->unsigned();
            $table->foreign('lf_transaction_id')->references('id')->on('lf_transactions')->onDelete('cascade')->onUpdate('cascade');
            $table->string('buyed_types');
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
        Schema::dropIfExists('beat_lf_transaction');
    }
}
