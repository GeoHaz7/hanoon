<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function edition()
    {
        return $this->belongsTo(Edition::class, 'edition_id');
    }

    public function category()
    {
        return $this->belongsToMany(Category::class, 'category_news');
    }

    // public function category()
    // {
    //     return $this->hasMany(Category::class, 'category_id');
    // }
}
