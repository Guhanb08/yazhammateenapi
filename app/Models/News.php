<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'brief' , 'status' , 'description'
    ];

    // In the News model
    public function categories()
    {
        return $this->belongsToMany(Category::class , 'news_categories');
    }
}
