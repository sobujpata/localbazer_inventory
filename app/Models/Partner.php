<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    protected $fillable = ["user_id", "amount", "image", "image2"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
