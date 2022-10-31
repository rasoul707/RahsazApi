<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedBigInteger('coupon_id')->nullable();
            $table->string('delivery_type')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('payment_type')->nullable();
            $table->timestamp('document_created_at')->nullable();
            $table->string('bank_receipt_number')->nullable();
            $table->unsignedInteger('last_four_digit_of_card')->nullable();
            $table->string('issue_tracking_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
