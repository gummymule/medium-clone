<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $categories = [
            'Technology',
            'Health',
            'Science',
            'Politics',
            'Education',
            'Finance',
            'Entertainment',
            'Sports',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
            ]);
        }

    }
}
