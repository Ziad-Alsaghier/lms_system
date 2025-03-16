<?php

namespace App\Http\Controllers\api\v1\admin\student;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\student\StoreRequest;
use App\Http\Requests\api\v1\admin\student\UpdateReques;
use App\Http\Resources\api\v1\admin\StudentResource;
use App\Http\Resources\api\v1\admin\UserResource;
use App\Models\User;
use App\services\Image;
use App\services\Package;

// use Illuminate\Http\Request;
class StudentController extends Controller
{
    //


    public function __construct(
        private User $user,
    ) {}
    use Image,Package;
    // This Function For Create Student
    public function store(StoreRequest $request)
    {
    $data = $request->validated();
    if(isset($data['student_id'])){
        $packageCheck = $this->checkActivation($data['package_id']);
         if ($packageCheck->active == false) {
         return response()->json([
         'message'=>"The Package $packageCheck?->name Is Not Available"
         ]);
         }
    }
       
        if ($request->hasFile('avatar')) {
    $data['avatar'] = $this->uploadImage($request->file('avatar'), 'avatars/');
    }

    $data['role'] = 'student';
    $teacher = $this->user->create($data);
    $teacher->avatar = $teacher->getAvatarUrl();

    return response()->json([
    'status' => 'success',
    'data' => $teacher,
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
        $studentResource = UserResource::make($user);
        $user->update($data);
        return response()->json([
            'status' => 'success',
            'user' => $studentResource
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
        $student = $this->user->where('role', 'student')->get();
            $student = StudentResource::collection($student);
        return response()->json([
            'status' => 'success',
            'data' => $student
        ], 200);
    }
}
