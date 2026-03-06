<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title',
        'text',
        'media_type',
        'media_path',
        'link_url',
        'comment_enabled',
        'comment_text',
        'comment_link',
        'comment_wait_seconds',
        'status',
    ];

    protected $casts = [
        'comment_enabled' => 'boolean',
        'comment_wait_seconds' => 'integer',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getPreviewText(int $length = 100): string
    {
        $text = $this->text ?? '';
        return mb_strlen($text) > $length
            ? mb_substr($text, 0, $length) . '...'
            : $text;
    }
}