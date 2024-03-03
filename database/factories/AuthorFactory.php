<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    use HasFactory;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }

    public function afterCreatingConfigure()
    {
        return $this->afterCreating(function (Author $author) {
            $author->profile()->save(Profile::factory()->create(['author_id' => $author->id]));
        });
    }

    public function afterMakingConfigure()
    {
        return $this->afterMaking(function (Author $author) {
            $author->profile()->save(Profile::factory()->create(['author_id' => $author->id]));
        });
    }
}
