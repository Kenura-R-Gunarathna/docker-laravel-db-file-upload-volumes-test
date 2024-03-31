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

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucfirst($value);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = ucfirst($value);
    }

    public function getImageUrlAttribute()
    {
        return asset($this->image_path);
    }
}
