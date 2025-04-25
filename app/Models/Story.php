<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Story extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'content',
        'thumbnail',
        'is_published',
        'audio_file',
        'video_file',
        'audio_duration',
        'video_duration',
        'audio_url',
        'video_url',
        'age_range',
        'reading_time'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'rating' => 'float',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
