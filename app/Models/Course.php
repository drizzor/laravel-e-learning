<?php

namespace App\Models;

use App\Models\User;
use App\Models\Episode;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;

class Course extends Model
{
    use HasFactory, Authorizable;

    protected $fillable = ['title', 'description'];

    protected $with = ['owner'];
    protected $withCount = ['episodes'];

    // Rajout d'un champ n'étant pas dans la table de mon modèle
    protected $appends = ['update'];

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

    /**
     * Je récupère l'attribut placé en appends en début de la classe pour le remplir
     */
    public function getUpdateAttribute()
    {
        // Update étant la gate init dans AuthService
        // return $this->authorize('update-course', $this);
        return $this->can('update-course', $this);
    }
}
