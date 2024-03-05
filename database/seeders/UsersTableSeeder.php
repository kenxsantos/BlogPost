<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userCount = (int)$this->command->ask('How many user would you like to add?', 20, 1);

        User::factory()->createDummyUser()->create();
        User::factory($userCount)->create();
    }
}
