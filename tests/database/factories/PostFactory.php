<?php
use Faker\Generator as Faker;
use \Lybc\BetterSoftDelete\Tests\Models\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'body' => $faker->paragraph
    ];
});
