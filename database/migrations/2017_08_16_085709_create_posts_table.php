<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url')->unique();
            $table->string('title', 140);
            $table->string('description', 170);
            $table->text('content');
            $table->string('image')->nullable();
            $table->boolean('blog');
            $table->unsignedInteger('category_id')->nullable();
            $table->timestamps();
            $table->string('created_at_ip');
            $table->string('updated_at_ip');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('posts');
    }
}
