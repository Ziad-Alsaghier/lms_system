<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    // This Is Package Model 
    protected $fillable = [
        'name',
        'sessionCount',
        'price',
        'status',
    ];

    public function student(){
    return $this->hasMany(User::class)->where('role','student');
    }
}
