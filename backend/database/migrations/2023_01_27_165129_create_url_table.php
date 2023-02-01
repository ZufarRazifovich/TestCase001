<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('url', function (Blueprint $table) {
            $table->id();
            $table->string('url', 255)->notNull();
            $table->integer('check_periodicity')->notNull();
            $table->integer('repeat_periodicity')->notNull();
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
        Schema::dropIfExists('url');
    }
}
