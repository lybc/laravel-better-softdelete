<?php
use Faker\Generator as Faker;
use \Lybc\BetterSoftDelete\Tests\Models\User;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'age' => $faker->numberBetween(1, 100)
    ];
});
