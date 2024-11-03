<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MiscellaneousCost extends Model
{
    protected $fillable = [
        "user_id", "recipient", "reason", "amount", "remarks"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
