<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'title',
        'description',
        'image_path',
    ];

    protected $casts = [
        'title' => 'string',
        'description' => 'string',
        'image_path' => 'string',
    ];

    protected function imageURL(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => asset($value),
        );
    }
}
