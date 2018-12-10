<?php
use Faker\Generator as Faker;
use \Lybc\BetterSoftDelete\Tests\Models\Post;
use \Lybc\BetterSoftDelete\Tests\Models\User;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'body' => $faker->paragraph,
        'user_id' => factory(User::class)->create()->id
    ];
});
