<?php

namespace App\Http\Controllers\api\v1\admin\student;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\student\StoreRequest;
use App\Http\Requests\api\v1\admin\student\UpdateReques;
use App\Models\User;
use App\services\Image;
// use Illuminate\Http\Request;
class StudentController extends Controller
{
    //


    public function __construct(
        private User $user,
    ) {}
    use Image;
    // This Function For Create Student
    public function store(StoreRequest $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/sitteng/teacher
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->uploadImage($request->file('avatar'), 'avatars/');
        }   
        $data['role'] = 'student';
        $teacher = $this->user->create($data);
        $teacher->avatar = $teacher->getAvatarUrl();
        return response()->json([
            'status' => 'success',
            'data' => $teacher
        ], 201);
    }
    public function update(UpdateReques $request, User $user)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/sitteng/teacher/{id}
        $data = $request->validated();

        if (!$user && $user->role != 'teacher') {
            return response()->json([
                'status' => 'error',
                'message' => 'user Not Found'
            ], 404);
        }
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->updateImage($request->file('avatar'), $user->avatar, 'avatars/');
        }
        $user->update($data);
        return response()->json([
            'status' => 'success',
            'user' => $user
        ], 200);
    }
    // This Function For Delete Teacher
    public function destroy($id)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/sitteng/teacher/{id}
        $teacher = $this->user->find($id);
        if (!$teacher) {
            return response()->json([
                'status' => 'error',
                'message' => 'Student Not Found'
            ], 404);
        }
        $teacher->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Student Deleted Successfully'
        ], 200);
    }





    // This Function For Show All Teacher
    public function show()
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/sitteng/teacher
        $teacher = $this->user->where('role', 'teacher')->get();

        return response()->json([
            'status' => 'success',
            'data' => $teacher
        ], 200);
    }
}
