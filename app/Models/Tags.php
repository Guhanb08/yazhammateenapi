<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tags extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'slug' , 'brief' , 'icon', 'orderby' ,  'isgeneral' , 'status'
    ];

    public function news()
    {
        return $this->belongsToMany(News::class  , 'news_tags' , 'tag_id' ,  'news_id' );
    }

}
