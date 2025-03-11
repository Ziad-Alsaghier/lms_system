<?php

namespace App\Http\Controllers\api\v1\teacher\profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\teacher\ProfileUpdate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function __construct(
        private User $user,
    ){}

    // This Function For Show Teacher Profile

    public function show(Request $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/teacher/profile
        $teacher = $request->user();
        return response()->json([
            'status' => 'success',
            'data' => $teacher
        ], 200);
    }

    // This Function For Update Teacher Profile

    public function update(ProfileUpdate $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/teacher/profile
        $teacher = $request->user();
        $data = $request->validated();
            if ($request->filled('password')) {
        if (Hash::check($request->password, $teacher->password)) {
            return back()->withErrors(['password' => 'The new password cannot be the same as the current password.']);
        }
        // Update password if it's different
    } else {
        unset($data['password']); // Remove password from update if not provided
    }
        $teacher->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Profile Updated Successfully'
        ], 200);
    }
}
