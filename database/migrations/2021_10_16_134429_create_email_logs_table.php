<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_email_log_id')->nullable();
            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->text('from_email_address')->nullable();
            $table->text('from_full_name')->nullable();
            $table->text('from_phone_number')->nullable();
            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->text('to_email_address')->nullable();
            $table->text('subject')->nullable();
            $table->text('body')->nullable();
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
        Schema::dropIfExists('email_logs');
    }
}
