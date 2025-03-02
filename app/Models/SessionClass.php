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
            'subject_id',
            'date',
            'start',
            'end',
            'status', // 'pending', 'processing', 'done', 'cancelled'
            'price',
            'active' , // 'active', 'inactive'
            'payment_method',
        // 'price',
    ];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

}
