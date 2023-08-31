<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bkcategory extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'type', 'slug', 'brief', 'bookflag' , 'image' , 'description', 'parent_id',  'category_id', 'subcategory_id', 'orderby', 'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Bkcategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Bkcategory::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Bkcategory::class, 'parent_id');
    }


    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function ancestors()
    {
        return $this->belongsTo(Bkcategory::class, 'parent_id')->with('ancestors');
    }


    public function bklists()
    {
        return $this->hasMany(Bklist::class, 'cat_id');
    }
}
