<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Laravel\Scout\Searchable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'first_name', 'last_name', 'email', 'user_role', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function notes() {
        return $this->hasMany(Note::class);
    }

    public function projects() {
        return $this->belongsToMany(Project::class, 'user_project', 'user_id', 'project_id');
    }

        /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }
}
