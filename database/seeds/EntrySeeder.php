<?php

use App\Category;
use App\Entry;
use Illuminate\Database\Seeder;

class EntrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::whereIn('name', ['Blood Pressure', 'Meal', 'Lunch'])->get();

        $categories->each(fn($category) => $this->createEntriesPerDayForNumberOFDays(3, $category));

        $weight = Category::whereName('Weight')->first();
        $this->createEntriesPerDayForNumberOFDays(1, $weight);
    }

    private function createEntriesPerDayForNumberOFDays(int $entriesPerDay, Category $category) : void
    {
        for ($currentDay = 0; $currentDay < 30; $currentDay++){
            for ($currentEntry = 0 ; $currentEntry < $entriesPerDay; $currentEntry++){
                factory(Entry::class)->create([
                    'category_id' => $category->id,
                    'created_at' => now()->endOfDay()->subDays($currentDay)->subHours(rand(1, 23))->subMinutes(rand(1, 59))
                ]);
            }
        }
    }


}
