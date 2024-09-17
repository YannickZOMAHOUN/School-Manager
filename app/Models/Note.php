<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $fillable=[
        'note',
        'recording_id',
        'ratio_id',
        'semester',
        'subject_id',
        'school_id',
    ];

    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function ratio(){
        return $this->belongsTo(Ratio::class);
    }
    public function recording(){
        return $this->belongsTo(Recording::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
