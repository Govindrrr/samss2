<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
    public function religion(): BelongsTo
    {
        return $this->belongsTo(Religion::class);
    }
    public function caste(): BelongsTo
    {
        return $this->belongsTo(Caste::class);
    }
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
}
