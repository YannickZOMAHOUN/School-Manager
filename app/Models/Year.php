<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    protected $fillable=[
        'year',
        'status',
        'school_id',
    ];

    public function recordings(){
        return $this->hasMany(Recording::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
