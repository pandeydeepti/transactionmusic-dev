<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beat extends Model
{
    protected $table = 'beats';
    protected $fillable = ['title','cover', 'mp3', 'bpm', 'wav', 'tracked_out', 'active', 'exclusive', 'mp3_price', 'wav_price', 'tracked_out_price', 'exclusive_price', 'exclusive_active', 'created_at', 'updated_at'];
    protected $primaryKey = 'id';

    public function rates()
    {
        return $this->belongsTo('App\Rate');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'beat_categories')->withTimestamps();
    }

    public function transactions()
    {
        return $this->belongsToMany('App\LfTransaction')->withTimestamps();
    }
    public function producers()
    {
        return $this->belongsToMany('App\Producer', 'beat_producers')->withTimestamps();
    }
    
    public function sound_likes()
    {
        return $this->belongsToMany('App\SoundLike', 'beat_sound_likes')->withTimestamps();
    }
}
