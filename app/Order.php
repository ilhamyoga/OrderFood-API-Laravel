<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['name', 'restaurant_id', 'pickup', 'request_notes'];
}
