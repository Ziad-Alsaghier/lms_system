<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // This Function For Define Fillable Column
    protected $fillable = ['name','status'];
}
