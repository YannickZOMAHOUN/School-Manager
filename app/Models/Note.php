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
        'subject_id'
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

}
