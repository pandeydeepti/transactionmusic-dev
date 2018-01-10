<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLfTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lf_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pay_id');
            $table->string('zip_path')->nullable();
            $table->float('total_money', 8, 2);
            $table->string('payment_state');
            $table->string('location');
            $table->softDeletes();
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
        Schema::dropIfExists('lf_transactions');
    }
}
