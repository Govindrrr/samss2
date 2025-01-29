<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Esetup extends Model
{
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
    public function subjects(): BelongsToMany
    {
        return $this->BelongsToMany(Subject::class);
    }
}
