<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            [
                'title' => 'Basic Flashcards',
                'description' => 'Learn with fun flashcards',
                'type' => 'flashcard',
                'is_published' => true,
                'content' => [
                    'cards' => [
                        [
                            'front' => 'What is the capital of France?',
                            'back' => 'Paris'
                        ],
                        [
                            'front' => 'What is 2 + 2?',
                            'back' => '4'
                        ],
                        [
                            'front' => 'What is the largest planet in our solar system?',
                            'back' => 'Jupiter'
                        ],
                        [
                            'front' => 'How many continents are there?',
                            'back' => '7'
                        ],
                        [
                            'front' => 'What is the chemical symbol for water?',
                            'back' => 'H2O'
                        ]
                    ],
                    'settings' => [
                        'showProgress' => true,
                        'shuffleCards' => true
                    ]
                ]
            ],
            [
                'title' => 'Basic Math',
                'description' => 'Practice basic math operations',
                'type' => 'math',
                'is_published' => true,
                'content' => [
                    'levels' => [
                        [
                            'name' => 'Addition',
                            'operations' => ['+'],
                            'min' => 1,
                            'max' => 10
                        ]
                    ],
                    'settings' => [
                        'time_limit' => 60,
                        'points_per_correct' => 10,
                        'points_needed_to_advance' => 50
                    ]
                ]
            ],
            [
                'title' => 'Fun Coloring Book',
                'description' => 'A fun coloring book for kids with various pictures to color.',
                'type' => 'coloring',
                'is_published' => true,
                'content' => [
                    'settings' => [
                        'brush_sizes' => [2, 5, 10, 15],
                        'default_brush_size' => 5,
                        'allow_custom_colors' => true,
                        'default_colors' => [
                            '#000000', // Black
                            '#FF0000', // Red
                            '#00FF00', // Green
                            '#0000FF', // Blue
                            '#FFFF00', // Yellow
                            '#FF00FF', // Magenta
                            '#00FFFF', // Cyan
                            '#FFA500', // Orange
                            '#800080', // Purple
                            '#008000', // Dark Green
                        ]
                    ],
                    'images' => []
                ]
            ]
        ];

        foreach ($games as $game) {
            $slug = Str::slug($game['title']);
            if (!Game::where('slug', $slug)->exists()) {
                Game::create($game);
            }
        }
    }
} 