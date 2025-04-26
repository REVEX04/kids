<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animeaux extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'type',
        'espece',
        'description',
        'image_path',
    ];

    protected $table = 'animeaux';
} 