<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratio extends Model
{
    use HasFactory;
    protected $fillable=[
        'ratio',
        'subject_id',
        'classroom_id',
    ];

    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function subject(){
        return $this->belongsTo(Subject::class);
    }
    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }
}
