<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $table = 'transaction_details';
    protected $fillable = ['meta_id', 'meta_key', 'meta_value', 'created_at', 'updated_at'];

}
