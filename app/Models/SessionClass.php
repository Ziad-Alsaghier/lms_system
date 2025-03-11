<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionClass extends Model
{
    //
    // protected $table = 'session_classes';
    protected $fillable = [
            'student_id',
            'teacher_id',
            'package_id',
            'date',
            'start',
            'end',
            // 'category',
            'status', // 'pending', 'processing', 'done', 'cancelled'
            'active' , // 'active', 'inactive'
            'payment_method',
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

   

}
