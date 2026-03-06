<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookProfile extends Model
{
    protected $fillable = [
        'name',
        'facebook_id',
        'profile_name',
        'profile_username',
        'profile_email',
        'profile_password',
        'cookies',
        'status',
        'last_login',
        'proxy_id',
        'notes',
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];

    public function proxy()
    {
        return $this->belongsTo(Proxy::class);
    }

    public function pages()
    {
        return $this->hasMany(FacebookPage::class, 'profile_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'facebook_profile_id');
    }

    public function activePagesCount(): int
    {
        return $this->pages()->count();
    }
}
