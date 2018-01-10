<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LfTransaction extends Model
{
    use SoftDeletes;
    protected $fillable = ['pay_id', 'total_money', 'zip_path', 'payment_state', 'location', 'created_at', 'updated_at'];

    public function customers()
    {
        return $this->belongsToMany('App\Customer')->withTimestamps();
    }

    public function beats()
    {
        return $this->belongsToMany('App\Beat')->withPivot('buyed_types')->withTimestamps();
    }

}
