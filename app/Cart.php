<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'order_list';

    protected $fillable = ['order_id', 'food_id', 'qty', 'request_note'];
}
