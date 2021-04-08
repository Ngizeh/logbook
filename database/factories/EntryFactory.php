<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Entry;
use Faker\Generator as Faker;

$factory->define(Entry::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->paragraph,
        'category_id' => fn() => factory(Category::class)
    ];
});
