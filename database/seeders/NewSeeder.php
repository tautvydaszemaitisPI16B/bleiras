<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        News::query()->delete();

        for ($i = 0; $i < 100; $i++) {
            News::create([
                'title' => fake()->sentence(),
                'content' => fake()->paragraphs(3, true),
                'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}
