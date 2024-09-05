<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;
    protected $fillable=[
        'classroom',
    ];

    public function recordings(){
        return $this->hasMany(Recording::class);
    }
    public function ratios(){
        return $this->hasMany(Ratio::class);
}

}
