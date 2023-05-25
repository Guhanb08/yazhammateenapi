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
        'title', 'brief' , 'imageone' , 'specname',  'imagetwo' ,  'imagethree' , 'imagefour' , 'author','articledate', 'audioone' , 'categoryid', 'subcategoryid', 'childcategoryid', 'slug' ,  'audiotwo' ,  'orderby' , 'status' , 'description'
    ];

    // In the News model
    public function categories()
    {
        return $this->belongsToMany(Category::class , 'news_categories');
    }


    public function tags()
    {
        return $this->belongsToMany(Tags::class , 'news_tags' , 'news_id', 'tag_id');
    }

    public function speciality()
    {
        return $this->belongsToMany(Speciality::class , 'news_speciality' ,  'news_id', 'speciality_id');
    }

}
