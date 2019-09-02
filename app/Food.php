<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'food_items';

    protected $fillable = ['restaurant_id', 'name', 'price', 'logo'];
}
