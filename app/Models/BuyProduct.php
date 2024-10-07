<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyProduct extends Model
{
    protected $fillable = [
        "type_of_product", "product_cost", "other_cost", "invoice_url"
    ];
}
