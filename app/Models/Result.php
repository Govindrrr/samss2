<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
}
