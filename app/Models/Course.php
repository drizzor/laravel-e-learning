<?php

namespace App\Models;

use App\Models\User;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $with = ['owner'];
    protected $withCount = ['episodes'];

    /**
     * Un cours peut être composé de plusieurs épisodes
     */
    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    /**
     * L'auteur du cours
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
