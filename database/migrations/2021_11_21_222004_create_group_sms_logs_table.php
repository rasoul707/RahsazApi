<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupSmsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_sms_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sms_id')->nullable();
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
        Schema::dropIfExists('group_sms_logs');
    }
}
