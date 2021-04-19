<?php

namespace Database\Factories;


use App\Models\Category;
use App\Models\Entry;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntryFactory extends Factory
{
    /**
     * The name of the corresponding model's factory
     *
     * @var string
     */
    protected $model = Entry::class;

    /**
     * Defines the default model state
     *
     * @return array
     */
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
