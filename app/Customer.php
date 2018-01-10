<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['payer_id', 'first_name', 'last_name', 'email', 'phone', 'country_code', 'shiping_recipient_name', 'shiping_line1', 'shiping_city', 'shiping_state', 'shiping_postal_code', 'shiping_country_code', 'created_at', 'updated_at'];
    protected $table = 'customers';
    public $timestamps = true;

    public function transactions()
    {
        return $this->belongsToMany('App\LfTransaction')->withTimestamps();
    }
}
