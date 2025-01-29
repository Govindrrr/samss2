<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class);
    }
    public function faculties(): BelongsToMany
    {
        return $this->belongsToMany(Faculty::class);
    }
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
    public function esetups(): BelongsToMany
    {
        return $this->BelongsToMany(Esetup::class);
    }
    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class);
    }
}

