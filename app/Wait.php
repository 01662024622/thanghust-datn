<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wait extends Model
{
    protected $fillable = [
        'table_id','product_id','status',
    ];
    protected $table= "waits";
}
