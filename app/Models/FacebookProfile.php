<?php

namespace App\\Models;

use Illuminate\\Database\\Eloquent\\Model;

class FacebookProfile extends Model
{
    protected $fillable = ['name', 'facebook_page_id', 'user_id', 'proxy_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function facebookPage()
    {
        return $this->belongsTo(FacebookPage::class);
    }

    public function proxy()
    {
        return $this->belongsTo(Proxy::class);
    }
}