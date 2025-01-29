<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Staff extends Model
{
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }
}
