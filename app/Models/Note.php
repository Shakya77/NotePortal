<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'sub_topic',
        'content',
        'components_used',
        'component_count',
        'description',
        'thumbnail'
    ];

    protected $casts = [
        'components_used' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Accessor to get formatted date
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('M d, Y');
    }

    // Accessor to get formatted time
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('h:i A');
    }

    // Scope to filter by topic
    public function scopeByTopic($query, $topic)
    {
        return $query->where('topic', $topic);
    }

    // Scope to filter by sub topic
    public function scopeBySubTopic($query, $subTopic)
    {
        return $query->where('sub_topic', $subTopic);
    }

    // Scope to search
    public function scopeSearch($query, $search)
    {
        return $query->where('topic', 'like', "%{$search}%")
            ->orWhere('sub_topic', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%");
    }
}
