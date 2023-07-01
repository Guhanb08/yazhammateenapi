<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tknews extends Model
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
        return $this->belongsToMany(Category::class , 'tknews_categories'  ,   'news_id' ,'category_id');
    }

}
