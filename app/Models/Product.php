<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

   protected $fillable = [ 'category_id', 'name','eng_name', 'buy_price', 'buy_qty', 'wholesale_price', 'img_url'];

}
