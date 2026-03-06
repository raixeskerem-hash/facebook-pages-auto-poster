<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends Model {
    protected $fillable = ['task_id', 'status', 'started_at', 'completed_at', 'log_message', 'error_message', 'response_code', 'response_data'];
    protected $casts = ['started_at' => 'datetime', 'completed_at' => 'datetime', 'response_data' => 'json'];

    public function task() {
        return $this->belongsTo(Task::class);
    }
}