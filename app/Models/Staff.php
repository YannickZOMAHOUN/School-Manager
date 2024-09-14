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
        'number',
        'user_id',
        'school_id',
        'role_id',


    ];
    public function school(){
        return $this->belongsTo(School::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
