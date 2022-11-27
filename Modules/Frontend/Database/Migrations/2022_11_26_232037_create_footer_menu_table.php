<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFooterMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_menu', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('priority')->nullable();
            $table->integer('xs')->default(12)->nullable();
            $table->integer('sm')->default(null)->nullable();
            $table->integer('md')->default(3)->nullable();
            $table->integer('lg')->default(null)->nullable();
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
        Schema::dropIfExists('footer_menu');
    }
}
