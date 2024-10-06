<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

   protected $fillable = ['user_id', 'category_id', 'name', 'buy_price', 'buy_qty', 'wholesale_price', 'img_url'];

}
