<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'type',
        'content',
        'is_published',
    ];

    protected $casts = [
        'content' => 'array',
        'is_published' => 'boolean',
    ];

    // Auto-generate slug from title
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($game) {
            if (empty($game->slug)) {
                $game->slug = Str::slug($game->title);
            }
        });
    }

    // Get all available game types
    public static function getTypes(): array
    {
        return [
            'flashcard' => 'Flashcards',
            'math' => 'Math Adventure',
            'coloring' => 'Coloring & Drawing',
        ];
    }

    // Get type display name
    public function getTypeDisplayName(): string
    {
        return self::getTypes()[$this->type] ?? $this->type;
    }

    // Get default content structure based on game type
    public static function getDefaultContent(string $type): array
    {
        return match($type) {
            'flashcard' => [
                'cards' => [],
                'settings' => [
                    'show_progress' => true,
                    'shuffle_cards' => true,
                ]
            ],
            'math' => [
                'levels' => [],
                'settings' => [
                    'time_limit' => 60,
                    'points_per_correct' => 10,
                    'points_needed_to_advance' => 50,
                ]
            ],
            'coloring' => [
                'images' => [],
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
                ]
            ],
            default => [],
        };
    }

    // Get content with defaults merged
    public function getContentAttribute($value)
    {
        $content = json_decode($value, true) ?? [];
        $defaults = self::getDefaultContent($this->type);
        
        return array_replace_recursive($defaults, $content);
    }

    // Set content
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = json_encode($value);
    }
} 