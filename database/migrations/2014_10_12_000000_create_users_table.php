<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->string('role')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->nullable();
            $table->unsignedTinyInteger('birth_year')->nullable();
            $table->unsignedTinyInteger('birth_month')->nullable();
            $table->unsignedTinyInteger('birth_day')->nullable();
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->text('address')->nullable();
            $table->text('legal_info_melli_code')->nullable();
            $table->text('legal_info_economical_code')->nullable();
            $table->text('legal_info_registration_number')->nullable();
            $table->text('legal_info_company_name')->nullable();
            $table->string('legal_info_state')->nullable();
            $table->string('legal_info_city')->nullable();
            $table->text('legal_info_address')->nullable();
            $table->text('refund_info_bank_name')->nullable();
            $table->text('refund_info_account_holder_name')->nullable();
            $table->text('refund_info_cart_number')->nullable();
            $table->text('refund_info_account_number')->nullable();
            $table->text('refund_info_sheba_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('temporary_sms_code')->nullable();
            $table->timestamp('temporary_sms_code_expired_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp('last_seen_at')->nullable();
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
        Schema::dropIfExists('users');
    }
}
