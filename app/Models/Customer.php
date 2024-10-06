<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name','shop_name','address','email','mobile','user_id'];
}
