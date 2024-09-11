<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'surname',
        'sex',
        'address',
        'number',
        'school_id',
        'role_id',

    ];
    public function school(){
        return $this->belongsTo(School::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
}
