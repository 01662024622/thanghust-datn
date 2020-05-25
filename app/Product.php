<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name','cost','description', 'content','category_id','slug','status'
    ];
}
