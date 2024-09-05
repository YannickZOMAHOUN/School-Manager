<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable=[
        'year',
    ];

    public function recordings(){
        return $this->hasMany(Recording::class);
    }
}
