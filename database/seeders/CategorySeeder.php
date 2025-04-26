<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Albums et histoires',
                'slug' => 'albums-et-histoires',
                'description' => 'Découvrez des histoires magnifiquement illustrées',
                'color' => '#2563eb',
                'order' => 1,
            ],
            [
                'name' => 'Fables et poésies',
                'slug' => 'fables-et-poesies',
                'description' => 'Des fables classiques et poèmes pour enfants',
                'color' => '#16a34a',
                'order' => 2,
            ],
            [
                'name' => 'Documentaires',
                'slug' => 'documentaires',
                'description' => 'Apprenez en vous amusant',
                'color' => '#9333ea',
                'order' => 3,
            ],
            [
                'name' => 'Contes et légendes',
                'slug' => 'contes-et-legendes',
                'description' => 'Des histoires magiques et merveilleuses',
                'color' => '#ea580c',
                'order' => 4,
            ],
            [
                'name' => 'Comptines et chansons',
                'slug' => 'comptines-et-chansons',
                'description' => 'Chantez et dansez avec vos chansons préférées',
                'color' => '#16a34a',
                'order' => 5,
            ],
            [
                'name' => 'English Stories',
                'slug' => 'english-stories',
                'description' => 'Learn English with fun stories',
                'color' => '#0284c7',
                'order' => 6,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
