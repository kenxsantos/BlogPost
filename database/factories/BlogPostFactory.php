<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'content' => fake()->paragraph(),
            'created_at' => fake()->dateTimeBetween('-3 months')
        ];

    }

    public function newTitle() {
        return BlogPost::factory()->state([
            'title' => 'New Title',
            'content' => 'Content of the blog post'
        ]);
    }
}
