<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $fillable = ['title', 'description', 'order', 'type', 'slug', 'created_at', 'updated_at'];
}
