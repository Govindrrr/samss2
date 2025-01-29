<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Level extends Model
{
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
    public function setups(): HasMany
    {
        return $this->hasMany(Esetup::class);
    }
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
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
