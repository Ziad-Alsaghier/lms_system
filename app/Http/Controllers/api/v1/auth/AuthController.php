<?php

namespace App\Http\Controllers\api\v1\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\auth\AuthRequst;
use App\Http\Resources\api\v1\admin\AdminResource;
use App\Http\Resources\api\v1\admin\StudentResource;
use App\Http\Resources\api\v1\admin\TeacherResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function __construct(
        private User $user
        ){}
    /**
    * Generate API token response
    */

    public function auth(AuthRequst $request)
  
    {
        // URL : http://localhost/lms_system/public/api/v1/auth/login
        $credentials = $request->validated(); // Get Email & Password From Request Validate
         
         $check = Auth::attempt($credentials);
        if ($check) { // Start Check Credentials
            $user = $this->user->where('email', $credentials['email'])->first(); // Get Current User Login
            $user->generateToken($user); // Genrate Token
            // Message Success
            $avatar = $user->avatar;
            $user->avatar = $user->getAvatarUrl();
            
                
            return response()->json([
                'auth.success' => 'Login Successfully',
                'user' => $user,
            ]);
                
            // Message Success
        } else {
            return response()->json(['message.auth' => 'Something Wrong In Your Credentials'], 400);
        }
    }

    function userResourse($user)
    {
            return   $resource = match ($user->role) {
            'admin' => new AdminResource($user),
            'teacher' => new TeacherResource($user),
            'student' => new StudentResource($user),
            };
    }
    

  


   
}
