<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tracks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('hash')->unique(); // metadata hash
            $table->integer('acceptor_id');

            // metadata
            $table->string('artist');
            $table->string('track');
            $table->string('album');
            $table->string('path');
            $table->string('tags')->index();

            $table->integer('requestcount')->default(0);
            $table->integer('priority')->default(0);

            $table->boolean('usable')->default(false)->index();
            $table->boolean('need_reupload')->default(false);
            $table->timestamp('lastplayed')->nullable();
            $table->timestamp('lastrequested')->nullable();
            $table->timestamps();

            // legacy, need removing at a later date
            $table->string('accepter');
            $table->string('lasteditor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('songs');
    }
}
