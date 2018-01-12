<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producer extends Model
{
    protected $fillable = ['title', 'description', 'active', 'cover', 'created_at', 'updated_at'];
    protected $table = 'producers';

    public function beat_producers()
    {
        return $this->belongsToMany('App\Beat', 'beat_producers');
    }
    public function beats()
    {
        return $this->belongsToMany('App\Beat', 'beats');
    }
    
}
