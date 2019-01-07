<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

    public function notes() {
    	return $this->hasMany(Note::class);
    }
}
