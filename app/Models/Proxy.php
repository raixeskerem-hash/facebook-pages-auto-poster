<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    protected $fillable = [ 'attribute1', 'attribute2', 'attribute3' ]; // Specify the fillable attributes

    // Relationship to FacebookProfile
    public function facebookProfile()
    {
        return $this->belongsTo(FacebookProfile::class);
    }
}