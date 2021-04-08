<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'region',
    ];

    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }
}
