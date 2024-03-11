<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;

class DatabaseSeeder extends Seeder
{
    protected static ?string $password;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
  
        if($this->command->confirm('Do you want to refresh your database?')){
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refresh');
        }

        Cache::tags(['blog-post'])->flush();
        
        $this->call([
            UsersTableSeeder::class,
            BlogPostTableSeeder::class,
            CommentsTableSeeder::class,
            TagsTableSeeder::class, 
            BlogPostTagTableSeeder::class
        ]);

    }
}
