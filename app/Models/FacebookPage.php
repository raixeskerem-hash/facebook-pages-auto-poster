<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookPage extends Model
{
    protected $fillable = ['profile_id', 'page_id', 'name', 'access_token'];

    public function profile()
    {
        return $this->belongsTo(FacebookProfile::class, 'profile_id');
    }

    public function taskPages()
    {
        return $this->hasMany(TaskPage::class, 'page_id');
    }
}