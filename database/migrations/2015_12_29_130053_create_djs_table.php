<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDjsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('djs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('theme_id')->nullable();
            $table->string('djname');
            $table->string('djimage')->nullable();
            $table->boolean('visible')->default(false);
            $table->integer('priority');

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
        Schema::drop('djs');
    }
}
