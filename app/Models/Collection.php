<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    protected $fillable=[
        'user_id','invoice_id', 'amount','due', 'invoice_url', 'customer_id'
    ];
    function invoice():BelongsTo{
        return $this->belongsTo(Invoice::class);
    }
}
