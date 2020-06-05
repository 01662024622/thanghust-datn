<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wait extends Model
{
    protected $fillable = [
        'order_id','product_id','status','quantity'
    ];
    protected $table= "waits";
}
