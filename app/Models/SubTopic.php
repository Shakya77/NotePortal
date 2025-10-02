<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTopic extends Model
{
    use HasFactory;

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function contents()
    {
        return $this->hasMany(Content::class);
    }
}
