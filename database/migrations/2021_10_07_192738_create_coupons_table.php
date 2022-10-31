<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->text('description')->nullable();

            $table->string('type')->nullable();
            $table->string('amount_type')->nullable();
            $table->unsignedDouble('amount')->nullable();
            $table->timestamp('expired_at')->nullable();
            $table->unsignedBigInteger('limit_count')->nullable();

            $table->unsignedDouble('dollar_price_for_gold_group')->nullable();
            $table->unsignedDouble('dollar_price_for_silver_group')->nullable();
            $table->unsignedDouble('dollar_price_for_bronze_group')->nullable();

            $table->unsignedDouble('min_amount')->nullable();
            $table->unsignedDouble('max_amount')->nullable();
            $table->boolean('only_use_for_special_products')->nullable()->default(0);


            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupons');
    }
}
