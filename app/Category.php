<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'description', 'active', 'cover', 'created_at', 'updated_at'];
    protected $table = 'categories';

    public function taxonomies()
    {
        return $this->belongsToMany('App\Taxonomy', 'category_taxonomies');
    }
    public function beats()
    {
        return $this->belongsToMany('App\Beats', 'beat_categories');
    }
}
