<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }
    public function results(): HasMany
    {
        return $this->hasMany(Result::class);
    }
}
