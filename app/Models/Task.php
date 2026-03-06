<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'facebook_profile_id',
        'content_id',
        'status',
        'scheduled_at',
        'total_pages',
        'completed_pages',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'total_pages' => 'integer',
        'completed_pages' => 'integer',
    ];

    public function profile()
    {
        return $this->belongsTo(FacebookProfile::class, 'facebook_profile_id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function pages()
    {
        return $this->belongsToMany(FacebookPage::class, 'task_pages', 'task_id', 'page_id');
    }

    public function taskPages()
    {
        return $this->hasMany(TaskPage::class);
    }

    public function isReadyToRun(): bool
    {
        return $this->status === 'pending'
            && ($this->scheduled_at === null || $this->scheduled_at->lte(now()));
    }

    public function getProgressPercentage(): float
    {
        if ($this->total_pages <= 0) {
            return 0.0;
        }
        return round(($this->completed_pages / $this->total_pages) * 100, 2);
    }
}
