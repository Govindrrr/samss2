<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    public function esetups(): HasMany
    {
        return $this->hasMany(Esetup::class);
    }
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
