<?php
use Faker\Generator as Faker;
use \Lybc\BetterSoftDelete\Tests\Models\Comment;
use \Lybc\BetterSoftDelete\Tests\Models\Post;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'content' => $faker->paragraph,
        'post_id' => factory(Post::class)->create()->id
    ];
});