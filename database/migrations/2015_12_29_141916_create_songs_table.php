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
            $table->integer('acceptor_id')->nullable();
            $table->enum('status', ['pending', 'accepted'])->default('pending');

            // metadata
            $table->string('artist');
            $table->string('track');
            $table->string('album');
            $table->string('path');
            $table->string('tags')->index();

            $table->integer('requestcount')->nullable()->default(0);
            $table->integer('priority')->nullable()->default(0);

            $table->boolean('usable')->default(false);
            $table->boolean('need_reupload')->default(false);
            $table->timestamp('lastplayed')->nullable();
            $table->timestamp('lastrequested')->nullable();
            $table->timestamps();

            // legacy, need removing at a later date
            $table->string('accepter')->default('');
            $table->string('lasteditor')->default('');

            $table->index(['usable', 'status', 'acceptor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tracks');
    }
}
