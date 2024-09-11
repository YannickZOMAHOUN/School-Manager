<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable=[
        'subject',
        'school_id',
    ];

    public function notes(){
        return $this->hasMany(Note::class);
    }
    public function ratios(){
        return $this->hasMany(Ratio::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
