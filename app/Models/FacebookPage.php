<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookPage extends Model
{
    protected $fillable = ['name', 'page_id', 'access_token'];

    public function profiles() {
        return $this->hasMany(FacebookProfile::class);
    }

    public function contents() {
        return $this->hasMany(Content::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}