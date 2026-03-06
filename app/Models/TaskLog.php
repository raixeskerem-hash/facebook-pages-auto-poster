<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model
{
    protected $fillable = [
        'task_page_id',
        'step',
        'action',
        'facebook_post_id',
        'facebook_comment_id',
        'log_message',
        'error_message',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function taskPage()
    {
        return $this->belongsTo(TaskPage::class);
    }

    public function getStepName(): string
    {
        $steps = [
            'switch_page' => 'Switch to Page',
            'share_post'  => 'Share Post',
            'add_comment' => 'Add Comment',
            'add_media'   => 'Add Media',
            'add_link'    => 'Add Link',
        ];
        return $steps[$this->step] ?? ucfirst((string) $this->step);
    }

    public function getActionName(): string
    {
        $actions = [
            'navigate'   => 'Navigate',
            'click'      => 'Click',
            'type'       => 'Type',
            'extract'    => 'Extract',
            'wait'       => 'Wait',
        ];
        return $actions[$this->action] ?? ucfirst((string) $this->action);
    }
}
