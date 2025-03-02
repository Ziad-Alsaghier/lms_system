<?php

namespace App\Http\Controllers\api\v1\admin\session;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\v1\admin\session\SessionClassRequest;
use App\Models\SessionClass;
use App\Models\User;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    //

    public function __construct(
        private SessionClass $sessionClass,
        private User $user
    ){}

    public function index()
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/session
        $sessions = $this->sessionClass->with('student', 'teacher')->get();
        return response()->json([
            'status' => 'success',
            'data' => $sessions
        ], 200);
    }

    public function store(SessionClassRequest $request)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/session
        $data = $request->validated();
        $session = $this->sessionClass->create($data);
        return response()->json([
            'status' => 'success',
            'data' => $session
        ], 201);
    }
        // This Function update Session Class Status
    public function update(Request $request, $id)
    {
        // URL : http://localhost/lms_system/public/api/v1/admin/session/{id}
        $session = $this->sessionClass->find($id);
        if (!$session) {
            return response()->json([
                'status' => 'error',
                'message' => 'Session Not Found'
            ], 404);
        }
        $session->update($request->all());
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
