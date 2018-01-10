<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $table = 'rates';
    protected $fillable = ['beat_id', 'amount', 'ip','created_at', 'updated_at'];

    public function beats()
    {
        return $this->belongsTo('App\Beat');
    }
}
