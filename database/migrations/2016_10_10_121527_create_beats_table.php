<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beats', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('active');
            $table->string('title');
            $table->string('cover');
            $table->string('mp3');
            $table->string('wav');
            $table->string('tracked_out');
            $table->boolean('exclusive_active');
            $table->float('bpm', 8, 2);
            $table->float('mp3_price', 8, 2);
            $table->float('wav_price', 8, 2);
            $table->float('tracked_out_price', 8, 2);
            $table->float('exclusive_price', 8, 2);
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
        Schema::dropIfExists('beats');
    }
}
