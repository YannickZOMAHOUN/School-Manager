<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable=[
        'classroom',
        'status',
        'promotion_recording_id',
        'year_id',
        'school_id',
    ];

    public function recordings(){
        return $this->hasMany(Recording::class);
    }
    public function ratios(){
        return $this->hasMany(Ratio::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
    public function promotionrecording(){
        return $this->belongsTo(PromotionRecording::class);
    }
    public function year(){
        return $this->belongsTo(Year::class);
    }
}
