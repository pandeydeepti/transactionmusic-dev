<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Taxonomy extends Model
{
    protected $table = 'taxonomies';

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_taxonomies');
    }
}
