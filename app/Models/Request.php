<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Request extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'status_id',
        'source_id',
        'group_id',
        'number_to_be_rescued',
        'address',
        'contact_number',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function priorities()
    {
        return $this->belongsToMany(Priority::class, 'priority_request')
            ->withTimestamps();
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeByGroup($query, $group_id)
    {
        if (empty($group_id)) {
            return $query;
        }

        return $query->where('group_id', '=', $group_id);
    }

    public function scopeByPriority($query, $priorities)
    {
        if (empty($priorities)) {
            return $query;
        }

        foreach ($priorities as $priority) {
            $query->whereHas('priorities', function ($query) use ($priority) {
                return $query->where('priority_id', $priority);
            });
        }

        return $query;
    }

    public function scopeByStatus($query, $status_ids)
    {
        if (empty($status_ids)) {
            return $query;
        }

        return $query->whereIn('status_id', $status_ids);
    }
}
