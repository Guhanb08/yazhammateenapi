<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Tkcategory extends Model
{
    
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'type', 'slug', 'cat_id', 'brief', 'description', 'parent_id',  'category_id', 'orderby', 'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Tkcategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Tkcategory::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Tkcategory::class, 'parent_id');
    }


    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function ancestors()
    {
        return $this->belongsTo(Tkcategory::class, 'parent_id')->with('ancestors');
    }

    public function tknews()
    {
        return $this->belongsToMany(Tknews::class  , 'tknews_categories' ,  'category_id', 'news_id'  );
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
