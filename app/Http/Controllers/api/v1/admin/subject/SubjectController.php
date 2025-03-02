<?php

namespace App\Http\Controllers\api\v1\admin\subject;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\subject\SubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // This Function For Create Subject
    public function __construct(
        private Subject $subject,
    ){}

    // This Function For Get All Subject
    public function index()
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/subject
        $subjects = $this->subject->all();
        return response()->json([
            'status' => 'success',
            'data' => $subjects
        ], 200);
    }
    // This Function For Create Subject
    public function store(SubjectRequest $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/subject
        $data = $request->all();
        $subject = $this->subject->create($data);
        return response()->json([
            'status' => 'success',
            'data' => $subject
        ], 201);
    }
    // This Function update Subject
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:active,inactive',
        ]);
        // URL : http://localhost/lms_system/public/api/v1/admin/subject/{id}
        $subject = $this->subject->find($id);
        if (!$subject) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subject Not Found'
            ], 404);
        }
        $subject->update($data);
        return response()->json([
            'status' => 'success',
            'data' => $subject
        ], 200);
    }
    // This Function For Delete Subject
    public function destroy($id)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/subject/{id}
        $subject = $this->subject->find($id);
        if (!$subject) {
            return response()->json([
                'status' => 'error',
                'message' => 'Subject Not Found'
            ], 404);
        }
        $subject->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Subject Deleted Successfully'
        ], 200);
    }

}
