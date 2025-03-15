<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $user =   User::where('email', $request->email)->first();
         if ($user->status == 'inactive') {
         return response()->json([
         'status' => 'error',
         'message' => 'Teacher Can\'t be authorized Casue UnActive'
         ], 403);
         }
        return $next($request);
    }
}
