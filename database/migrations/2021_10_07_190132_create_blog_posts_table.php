<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('written_by_user_id')->nullable();
            $table->string('status')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->text('slug')->nullable();
            $table->text('image')->nullable();
            $table->boolean('has_educational_video')->default(0)->nullable();
            $table->unsignedBigInteger('views_count')->default(0)->nullable();
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
        Schema::dropIfExists('blog_posts');
    }
}
