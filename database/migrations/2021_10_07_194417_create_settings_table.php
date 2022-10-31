<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable();
            $table->unsignedDouble('currency_price_for_gold_group')->nullable();
            $table->unsignedDouble('currency_price_for_silver_group')->nullable();
            $table->unsignedDouble('currency_price_for_bronze_group')->nullable();
            $table->boolean('use_for_all_products_with_currency')->nullable()->default(false);
            $table->unsignedDouble('taxation_percentage')->nullable();
            $table->unsignedDouble('charges_percentage')->nullable();
            $table->boolean('is_rounding_enable')->nullable()->default(false);
            $table->unsignedDouble('rounding_price')->nullable();
            $table->string('rounding_target')->nullable();
            $table->string('rounding_flag')->nullable();
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
        Schema::dropIfExists('settings');
    }
}
