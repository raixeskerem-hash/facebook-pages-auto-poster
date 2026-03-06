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
        return $this->belongsTo(TaskPage::class, 'task_page_id');
    }

    public function getStepName(): string
    {
        $steps = [
            'switch_profile' => 'Profil Değiştir',
            'switch_page'    => 'Sayfa Değiştir',
            'post'           => 'Gönderi Paylaş',
            'comment'        => 'Yorum Ekle',
            'verify'         => 'Doğrula',
        ];

        return $steps[$this->step] ?? $this->step ?? '';
    }

    public function getActionName(): string
    {
        $actions = [
            'navigate'  => 'Sayfaya Git',
            'click'     => 'Tıkla',
            'type'      => 'Yaz',
            'upload'    => 'Yükle',
            'extract'   => 'Çıkar',
            'wait'      => 'Bekle',
        ];

        return $actions[$this->action] ?? $this->action ?? '';
    }
}
