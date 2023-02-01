<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckurlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkurl', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('url_id');
            $table->foreign('url_id')->references('id')->on('url');
            $table->integer('http_code')->notNull();
            $table->integer('attempt_number')->notNull();
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
        Schema::dropIfExists('checkurl');
    }
}
