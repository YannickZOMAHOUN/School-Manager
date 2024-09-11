<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable=[
        'school',
        
    ];

    public function recordings(){
        return $this->hasMany(Recording::class);
    }
    public function classrooms(){
        return $this->hasMany(Classroom::class);
    }
    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function ratio(){
        return $this->hasMany(Ratio::class);
    }
    public function staff(){
        return $this->hasMany(Staff::class);
    }
    public function students(){
        return $this->hasMany(Student::class);
    }
    public function subjects(){
        return $this->hasMany(Subject::class);
    }
    public function users(){
        return $this->hasMany(User::class);
    }
    public function years(){
        return $this->hasMany(Year::class);
    }
}
