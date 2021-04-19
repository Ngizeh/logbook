<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Ngizeh Mwas',
            'email' => 'ngizeh@gmail.com',
            'password' => bcrypt('password')
        ]);
    }
}
