<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoundLike extends Model
{
    protected $fillable = ['title', 'description', 'active', 'cover', 'created_at', 'updated_at'];
    protected $table = 'sound_likes';

    public function taxonomies()
    {
        return $this->belongsToMany('App\Taxonomy', 'category_taxonomies')->where('category_taxonomies.taxonomy_id', '=', '3');
    }
    public function beats()
    {
        return $this->belongsToMany('App\Beats', 'beat_producers');
    }
}
