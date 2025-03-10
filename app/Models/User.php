<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Resources\api\v1\teacher\CurrentSession;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $primaryKey = 'id';
        
    protected $fillable = [
        'username',
        'email',
        'password',
        'avatar',
        'role',
        'phone',
        'address',
        'age',
        'parent_phone',
        'category',
        'payment_method',
        'status',
        'subject_id',
        'sessionCount',
    ];

    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
       protected $append = ['avatar_url'];

      

    /**
     * Generate an API token for the user.
     *
     * @return string
     */
     public function generateToken($user){
     $user->token = $user->createToken('personal access token')->plainTextToken;
     return $user;
     }

     public function regenerateToken($user){
     $user->tokens()->delete();
     $user->token = $user->createToken('personal access token')->plainTextToken;
     return $user;
     }
        public function getAvatarUrlAttribute()
         {
        return $this->avatar ? url('storage/ava' . $this->attributes['avatar'])
        : url('storage/avatars/default.png');

          
         }

        public function getAvatarUrl()
        {
            return $this->avatar
                ? asset('storage/' . $this->avatar)
                : asset('storage/avatars/default.png'); // Default avatar
        }
 
        public function subject()
        {
            return $this->belongsTo(Subject::class);
        }
        public function teacherSessions()
        {
            return $this->hasMany(SessionClass::class, 'teacher_id')->whereNotNull('start')->whereNotNull('end');
        }
        public function studentSessions()
        {
            return $this->hasMany(SessionClass::class, 'student_id')->whereNotNull('start')->whereNotNull('end');
        }

        public function getCurrentMonthSessions()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $sessions = $this->teacherSessions()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get();

        $daysWithSessions = [];

        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
            $day = $date->format('Y-m-d');

            $daySessions = $sessions->where('date', $day);

            $daysWithSessions[] = [
                'date' => $day,
                'sessions' => $daySessions->isNotEmpty()
                    ? CurrentSession::collection($daySessions)
                    : "You don't have a session on this day",
            ];
        }

        return $daysWithSessions;
    }
}
