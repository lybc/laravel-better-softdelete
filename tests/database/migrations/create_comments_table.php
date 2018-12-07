<?php

class CreateCommentsTable extends \Illuminate\Database\Migrations\Migration
{
    public function up()
    {
        \Illuminate\Support\Facades\Schema::create(
            'comments',
            function (\Illuminate\Database\Schema\Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('post_id');
                $table->string('content');
                $table->betterSoftDeletes();
            }
        );
    }

    public function down()
    {
        \Illuminate\Support\Facades\Schema::dropIfExists('comments');
    }
}