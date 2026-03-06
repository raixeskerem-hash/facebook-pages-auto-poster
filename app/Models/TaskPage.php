<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskPage extends Model
{
    protected $fillable = [
        'task_id',
        'page_id',
        'status',
        'post_id',
        'comment_id',
        'comment_status',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function page()
    {
        return $this->belongsTo(FacebookPage::class, 'page_id');
    }

    public function logs()
    {
        return $this->hasMany(TaskLog::class, 'task_page_id');
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
