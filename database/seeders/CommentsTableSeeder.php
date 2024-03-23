<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blog_post = BlogPost::all();
        $users = User::all();

        if($blog_post ->count() === 0 || $users->count() === 0){
            $this->command->info('There are no blog post or users, so no comments will be added');
            return;
        }

        $commentCount = (int)$this->command->ask('How many comments would you like to add?', 150);

         Comment::factory($commentCount)->make()->each(function ($comment) use ($blog_post, $users){
            $comment->commentable_id = $blog_post->random()->id;
            $comment->commentable_type = BlogPost::class;
            $comment->user_id = $users->random()->id;
            $comment->save(); 
        });

         Comment::factory($commentCount)->make()->each(function ($comment) use ($users){
            $comment->commentable_id = $users->random()->id;
            $comment->commentable_type = User::class;
            $comment->user_id = $users->random()->id;
            $comment->save(); 
        });
    }
}
