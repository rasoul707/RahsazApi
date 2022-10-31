<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('note_before_buy')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->text('description')->nullable();

            // general info
            $table->unsignedDouble('price_in_toman')->nullable();
            $table->unsignedDouble('price_in_toman_for_gold_group')->nullable();
            $table->unsignedDouble('price_in_toman_for_silver_group')->nullable();
            $table->unsignedDouble('price_in_toman_for_bronze_group')->nullable();
            $table->unsignedDouble('special_sale_price')->nullable();
            $table->timestamp('special_price_started_at')->nullable();
            $table->timestamp('special_price_expired_at')->nullable();
            $table->boolean('price_depends_on_currency')->default(false)->nullable();
            $table->string('currency')->nullable();
            $table->unsignedDouble('currency_price_for_gold_group')->nullable();
            $table->unsignedDouble('currency_price_for_silver_group')->nullable();
            $table->unsignedDouble('currency_price_for_bronze_group')->nullable();
            $table->unsignedDouble('weight')->nullable();
            $table->unsignedDouble('length')->nullable();
            $table->unsignedDouble('width')->nullable();
            $table->unsignedDouble('height')->nullable();

            // mojoodi
            $table->string('identifier')->nullable();
            $table->boolean('management_enable')->default(false)->nullable();
            $table->unsignedBigInteger('supply_count_in_store')->nullable();
            $table->unsignedBigInteger('low_supply_alert')->nullable();
            $table->boolean('only_sell_individually')->default(false)->nullable();
            $table->string('shelf_code')->nullable();
            $table->unsignedDouble('supplier_price')->nullable();

            $table->timestamps();
        });

        Schema::create('product_other_names', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->text('name')->nullable();
            $table->timestamps();
        });

        Schema::create('product_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('image_id');
            $table->timestamps();
        });

        Schema::create('similar_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('target_product_id');
            $table->unsignedBigInteger('similar_product_id');
            $table->timestamps();
        });

        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->text('attribute_key');
            $table->text('attribute_value');
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
        Schema::dropIfExists('products');
    }
}
