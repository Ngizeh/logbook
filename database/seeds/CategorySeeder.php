<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(['name' => 'Blood Pressure']);
        DB::table('categories')->insert(['name' => 'Lunch']);
        DB::table('categories')->insert(['name' => 'Meal']);
        DB::table('categories')->insert(['name' => 'Weight']);
    }
}
