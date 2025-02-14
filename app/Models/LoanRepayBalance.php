<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoanRepayBalance extends Model
{
    protected $fillable = [
        'user_id',
        'bank_id',
        'installment_no',
        'pay_amount',
        'total_pay',
        'balance',
    ];
    function banks():BelongsTo{
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }
    function user():BelongsTo{
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
