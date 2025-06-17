<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Batch extends Model
{
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
