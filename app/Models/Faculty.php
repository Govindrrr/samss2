<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    public function levels():  HasMany
    {
        return $this->hasMany(Level::class);
    }
    public function esetups():  HasMany
    {
        return $this->hasMany(Esetup::class);
    }
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class);
    }
    public function students(): HasMany
    {
        return $this->hasMany((Student::class));
    }
}
