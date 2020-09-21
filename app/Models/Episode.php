<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model
{
    use HasFactory;

    /**
     * Les épisodes appartiennent à un cours distinct
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
