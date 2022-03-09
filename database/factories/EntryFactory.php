<?php

namespace Database\Factories;

use App\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class EntryFactory extends Factory
{
	public function definition()
	{
	    $timeOfDay = ['Morning', 'Afternoon', 'Evening'];

	    return [
	        'title' => Arr::random($timeOfDay),
	        'description' => $this->faker->paragraph,
	        'category_id' => fn() => Category::factory()->create()
	    ];

	}

}
