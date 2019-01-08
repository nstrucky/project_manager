<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function notes() {
    	return $this->hasMany(Note::class);
    }

    public function tasks() {
    	return $this->hasMany(Task::class);
    }

    public function users() {
    	return $this->hasMany(User::class);
    }
}
