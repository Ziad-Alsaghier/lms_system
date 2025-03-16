<?php

namespace App\Http\Controllers\api\v1\admin\session;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\session\SessionClassRequest;
use App\Http\Requests\api\v1\admin\session\SessionClassUpdate;
use App\Http\Resources\api\v1\session\SessionResource;
use App\Models\Package;
use App\Models\SessionClass;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    //

    public function __construct(
        private SessionClass $sessionClass,
        private User $user,
        private Package $package
    ) {}

    public function index()
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/session
        $sessions = $this->sessionClass->with('student', 'teacher')->get();
        $sessions = SessionResource::collection($sessions);
        return response()->json([
            'status' => 'success',
            'data' => $sessions
        ], 200);
    }

    public function store(SessionClassRequest $request)
    {

        try {
            // URL : http://localhost/lms_system/public/api/v1/admin/session
            $data = $request->validated();
            $sessionCount = $this->sessionClass->whereDate('date', $data['date'])->count();
            $student = $this->user->find($data['student_id']);
            $packageCheck = $this->checkStudentPackage($student);
            if (!$packageCheck && !isset($data['package_id'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'This Student Don\'t Have Package You Can Add Session For Session and automatically Added For Student '
                ], 500);
            } elseif ($packageCheck && isset($data['package_id'])) {
                return response()->json([
                    'message' => ' can\'t be Add Session hase package Cause student have Package',
                ], 501);
            }
            if (isset($data['package_id'])) {
                $package = $this->package->find($data['package_id']);
                $student->package_id = $package->id;
                $student->sessionsLimite = $package->sessionCount;
                $student->save();
            }
            if ($student->package_id != Null) {
                if($student->sessionsLimite == 0){
                           return response()->json([
                           'message' => __('انتهت حصص هذا الطالب. يجب تحديث اشتراكه.'),
                           ],501);
                }
                $packageStudent = $student->package;
                $student->sessionsLimite = $packageStudent->sessionCount - $student->sessionsLimite ;
                $student->save();
            } else {
                return response()->json([
                    'message' => __('انتهت حصص هذا الطالب. يجب تحديث اشتراكه.'),
                ], 500);
            }

            $session = $this->sessionClass->create($data);
            return response()->json([
                'status' => 'success',
                'data' => $session
            ], 201);
        } catch (QueryException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
        //     if ($sessionCount >= 3) {
        // return response()->json([
        // 'status' => 'error',
        // 'message' => 'You cannot add more than three sessions on the same day.'
        // ], 422);
        // }


    }


    public function checkStudentPackage($student)
    {
        if ($student->package != null) {
            return true;
        } else {
            return false;
        }
    }
    // This Function update Session Class Status
    public function update(SessionClassUpdate $request, $id)
    {
        $data = $request->validated();
        // URL : http://localhost/lms_system/public/api/v1/admin/session/{id}
        $session = $this->sessionClass->find($id);
        if (!$session) {
            return response()->json([
                'status' => 'error',
                'message' => 'Session Not Found'
            ], 404);
        }
        $session->update($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Session Updated Successfully'
        ], 200);
    }

    // This Function For Delete Session
    public function destroy($id)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/session/{id}
        $session = $this->sessionClass->find($id);
        if (!$session) {
            return response()->json([
                'status' => 'error',
                'message' => 'Session Not Found'
            ], 404);
        }
        $session->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Session Deleted Successfully'
        ], 200);
    }

    public function getSessionsForCurrentMonth()
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/session/current-month
        /*
            * Get all sessions for the current month    
            Data returned is 
            [
                {
                    "day" => 'date',
                    "student",
                    "status": "active","inactive",
                }
            ]                      
         */
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $sessions = $this->sessionClass
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->with('student', 'teacher')
            ->get();
        return response()->json([
            'status' => 'success',
            'data' => $sessions
        ], 200);
    }
}
