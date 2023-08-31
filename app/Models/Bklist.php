<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bklist extends Model
{
    
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'type', 'slug', 'cat_id', 'brief', 'description', 'parent_id',  'category_id', 'orderby', 'status'
    ];

    public function parent()
    {
        return $this->belongsTo(Bklist::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Bklist::class, 'parent_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Bklist::class, 'parent_id');
    }


    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    public function ancestors()
    {
        return $this->belongsTo(Bklist::class, 'parent_id')->with('ancestors');
    }

    public function category()
    {
        return $this->belongsTo(Bkcategory::class);
    }
}
