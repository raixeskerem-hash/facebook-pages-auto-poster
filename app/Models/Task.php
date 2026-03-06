<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['name', 'status', 'facebook_page_id', 'content_id'];

    public function facebookPage()
    {
        return $this->belongsTo(FacebookPage::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function taskLogs()
    {
        return $this->hasMany(TaskLog::class);
    }
}