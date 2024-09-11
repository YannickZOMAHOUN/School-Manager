<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['role_name'];

    public function staff(){
        return $this->hasMany(Staff::class);
    }
    public function school(){
        return $this->belongsTo(School::class);
    }
}
