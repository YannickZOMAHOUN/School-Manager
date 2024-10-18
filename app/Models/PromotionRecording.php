<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionRecording extends Model
{
    use HasFactory;
    protected $fillable=[
        'promotion_id',
        'year_id',
        'school_id',
    ];
    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }
    public function year(){
        return $this->belongsTo(Year::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
