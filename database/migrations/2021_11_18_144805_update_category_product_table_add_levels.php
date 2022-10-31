<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCategoryProductTableAddLevels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_product', function (Blueprint $table) {
            $table->unsignedBigInteger('category_level_1_id')->nullable();
            $table->unsignedBigInteger('category_level_2_id')->nullable();
            $table->unsignedBigInteger('category_level_3_id')->nullable();
            $table->unsignedBigInteger('category_level_4_id')->nullable();
            $table->removeColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_product', function (Blueprint $table) {
            //
        });
    }
}
