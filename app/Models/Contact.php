<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_id',
        'contact_no',
        'rescuers'
    ];

    public function region(){
        return $this->belongsTo(Region::class);
    }
}
