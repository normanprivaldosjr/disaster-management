<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'status_id',
        'source_id',
        'group_id',
        'priority',
        'number_to_be_rescued',
        'address',
        'contact_number',
    ];

    public function source(){
       return $this->belongsTo(Source::class);
    }

    public function notes(){
        return $this->hasMany(Note::class);
    }

    public function groups(){
        return $this->belongsTo(Group::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
