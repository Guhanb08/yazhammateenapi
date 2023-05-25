<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;



class Speciality extends Model
{

    protected $table = 'speciality'; 

    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',   'title', 'slug' , 'brief' , 'icon', 'orderby'  , 'status'
    ];

    public function news()
    {
        return $this->belongsToMany(News::class  , 'news_speciality');
    }
}
