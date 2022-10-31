<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulk_sms_logs', function (Blueprint $table) {
            $table->id();
            $table->text('text')->nullable();
            $table->text('status')->nullable();
            $table->timestamps();
        });

        Schema::create('bulk_sms_log_targets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bulk_sms_log_id')->nullable();
            $table->text('target_type')->nullable();
            $table->unsignedBigInteger('target_id')->nullable();
            $table->boolean('is_allowed')->nullable();
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
        Schema::dropIfExists('bulk_sms_logs');
    }
}
