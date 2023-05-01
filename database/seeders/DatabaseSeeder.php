<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        for ($i = 0; $i < 15; $i++) {
            Author::factory()
                ->has(Post::factory()->count(rand(20, 30)), 'posts')
                ->create();
        }
    }
}
