<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model {
    protected $fillable = ['facebook_page_id', 'text', 'media_type', 'media_path', 'link_url', 'status'];

    public function facebookPage() {
        return $this->belongsTo(FacebookPage::class);
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }
}