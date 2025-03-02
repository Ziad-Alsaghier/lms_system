<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    // This Function For Define Fillable Column
    protected $fillable = ['name', 'status'];

    // This Function For Define Hidden Column
    protected $hidden = ['created_at', 'updated_at'];

    // This Function For Define Casts Column
    protected $casts = ['status' => 'string'];

    // This Function For Define Default Value
    protected $attributes = ['status' => 'active'];

    // This Function For Define Validation Rule
   
}
