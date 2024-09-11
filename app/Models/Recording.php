<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recording extends Model
{
    use HasFactory;
    protected $fillable=[
        'student_id',
        'year_id',
        'classroom_id',
        'school_id',
    ];
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function classroom(){
        return $this->belongsTo(Classroom::class);
    }
    public function year(){
        return $this->belongsTo(Year::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
