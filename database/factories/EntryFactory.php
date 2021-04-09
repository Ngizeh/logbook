<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use App\Entry;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Entry::class, function (Faker $faker) {
    $timeOfDay = ['Morning', 'Afternoon', 'Evening'];

    return [
        'title' => Arr::random($timeOfDay),
        'description' => $faker->paragraph,
        'category_id' => fn() => factory(Category::class)
    ];
});
