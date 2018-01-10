<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShopOption extends Model
{
    protected $table = 'shop_options';
    protected $fillable = ['meta_key', 'meta_value', 'created_at', 'updated_at'];
}
