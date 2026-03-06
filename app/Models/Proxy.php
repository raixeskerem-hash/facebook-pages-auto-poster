<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    protected $fillable = [
        'ip_address',
        'port',
        'username',
        'password',
        'status',
    ];

    public function profiles()
    {
        return $this->hasMany(FacebookProfile::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function getFullAddress(): string
    {
        if ($this->username && $this->password) {
            return "{$this->username}:{$this->password}@{$this->ip_address}:{$this->port}";
        }

        return "{$this->ip_address}:{$this->port}";
    }
}
