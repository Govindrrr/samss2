<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mark extends Model
{
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }
}
