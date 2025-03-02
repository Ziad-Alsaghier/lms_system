<?php

namespace App\Http\Controllers\api\v1\teacher\profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

    public function update(Request $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/teacher/profile
        $teacher = $request->user();
        $data = $request->all();
        $teacher->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Profile Updated Successfully'
        ], 200);
    }
}
