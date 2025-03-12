<?php

namespace App\Http\Controllers\api\v1\admin\sitteng;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\teacher\StoreRequest;
use App\Http\Requests\api\v1\admin\teacher\UpdateRequest;
use App\Http\Resources\api\v1\admin\TeacherResource;
use App\Models\User;
use App\services\Image;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // This Controller About All Setting Teacher
    public function __construct(
        private User $user
    ) {}
    use Image;
    // This Function For Create Teacher
    public function store(StoreRequest $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/sitteng/teacher

        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->uploadImage($request->file('avatar'), 'avatars/');
        }
        $teacher = $this->user->create($data);
        $teacher->avatar = $teacher->getAvatarUrl();
        return response()->json([
            'status' => 'success',
            'data' => $teacher
        ], 201);
    }

    // This Function about Update Teacher
    public function update(UpdateRequest $request, User $user)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/sitteng/teacher/{id}
        $data = $request->validated();
        if (!$user or $user->role != 'teacher') {
            return response()->json([
                'status' => 'error',
                'message' => $user ? 'User Not Teacher' : 'User Not Found'
            ], );
        }

            
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $this->updateImage($request->file('avatar'), $user->avatar, 'avatars/');
        }
        if(empty($request->password)){
           $data['password'] = $user->password ?? $request->password;
        }else{
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        return response()->json([
            'status' => 'success',
            'message' => $user
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
                'message' => 'Teacher Not Found'
            ], 404);
        }
        $teacher->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Teacher Deleted Successfully'
        ], 200);
    }





    // This Function For Show All Teacher
    public function show()
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/sitteng/teacher
        $teacher = $this->user->where('role', 'teacher')->get();
            $teacher = TeacherResource::collection($teacher);
        return response()->json([
            'status' => 'success',
            'data' => $teacher
        ], 200);
    }
}
