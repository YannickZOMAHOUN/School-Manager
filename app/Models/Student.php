<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable=[
        'matricule',
        'name',
        'surname',
        'sex',
        'birthday',
        'birthplace',
        'school_id',
    ];

    public function recordings(){
        return $this->hasMany(Recording::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
