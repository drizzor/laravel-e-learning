<?php

namespace App\Models;

use App\Models\User;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    protected $fillable = ['title', 'description'];

    use HasFactory;

    protected $with = ['owner'];
    protected $withCount = ['episodes'];

    protected static function booted()
    {
        // Au moment de la création d'un cours j'applique automatiquemnt l'id de l'utilisateur connecté qui est nécessaire pour cette table. 
        // Ca m'évite de devoir le faire depuis le controlleur
        static::creating(function ($course) {
            $course->user_id = auth()->id();
        });
    }

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
