<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('payer_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('country_code');
            $table->string('shiping_recipient_name');
            $table->string('shiping_line1');
            $table->string('shiping_city');
            $table->string('shiping_state');
            $table->string('shiping_postal_code');
            $table->string('shiping_country_code');
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
        Schema::dropIfExists('customers');
    }
}
