<?php

namespace Database\Seeders;

use App\Models\Story;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            // Create 3 stories per category
            for ($i = 1; $i <= 3; $i++) {
                $title = "Story $i in " . $category->name;
                
                Story::create([
                    'category_id' => $category->id,
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'description' => "This is a sample story in the {$category->name} category. It's perfect for kids who love reading!",
                    'content' => "
                        <h2>Chapter 1: The Beginning</h2>
                        <p>Once upon a time, in a magical world far away, there lived a curious child who loved to learn new things...</p>
                        
                        <h2>Chapter 2: The Adventure</h2>
                        <p>One day, while exploring the enchanted forest, our hero made an amazing discovery...</p>
                        
                        <h2>Chapter 3: The Lesson</h2>
                        <p>And so, after this wonderful adventure, everyone learned that the most important thing is to believe in yourself and never stop learning!</p>
                    ",
                    'views' => rand(10, 100),
                    'rating' => rand(35, 50) / 10,
                    'rating_count' => rand(5, 20),
                    'is_published' => true,
                ]);
            }
        }
    }
}
