<?php

class CreatePostsTable extends \Illuminate\Database\Migrations\Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create(
            'posts',
            function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->increments('id');
                $table->string('title');
                $table->text('body');
                $table->betterSoftDeletes();
            }
        );
    }

    public function down()
    {
        \Illuminate\Support\Facades\Schema::dropIfExists('posts');
    }
}