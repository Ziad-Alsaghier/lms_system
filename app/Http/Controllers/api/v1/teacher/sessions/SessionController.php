<?php

namespace App\Http\Controllers\api\v1\teacher\sessions;

use App\Http\Controllers\Controller;
use App\Http\Resources\api\v1\teacher\CurrentSession;
use App\Models\SessionClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct(
        private SessionClass $sessionClass) {}
    //  Show This Current Teacher Sessions For This Month
    public function showCurrentMonthSessions(Request $request)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Fetch sessions for the current month
        $sessions = $this->sessionClass->whereBetween('date', [$startOfMonth, $endOfMonth])->get();
            
        // Build array of all days in the month
        $daysWithSessions = [];

        for ($date = $startOfMonth; $date->lte($endOfMonth); $date->addDay()) {
        $day = $date->format('Y-m-d');

        // Filter sessions for the current day
        $daySessions = $sessions->where('date', $day)->values();
            
                 $daySessions = CurrentSession::collection($daySessions);
        $daysWithSessions[] = [
        'date' => $day,
        'sessions' => $daySessions->isEmpty() ? "You Don't Have Session In This Day" : $daySessions,
        ];
        }

        return response()->json($daysWithSessions);
    }

    // Show This Current Teacher Sessions For This Day
    public function showCurrentDaySessions(Request $request)
    {
        $teacherId = $request->user()->id;
        $currentDay = date('d');
        $currentMonth = date('m');
        $currentYear = date('Y');
        $sessions = $this->sessionClass::where('teacher_id', $teacherId)
            ->whereDay('created_at', $currentDay)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'pending')
            ->get();
        return response()->json($sessions);
    }


    /**
     * Update the session status to 'Processing'.
     * 
     * If the session is scheduled for today or a future date, update the session status to 'Processing'.
     * If the session is scheduled for a past date, send a message indicating that the session cannot be updated.
     */
    // Update Session to Processing
    public function updateSessionToProcessing(Request $request, $sessionId)
    {
        $teacherId = $request->user()->id;
        $currentDay = date('d');
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Check if there are any pending sessions before this session
        $pendingSessions = $this->sessionClass::where('teacher_id', $teacherId)
            ->whereDay('created_at', $currentDay)
            ->whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->where('status', 'pending')
            ->where('id', '<', $sessionId)
            ->exists();

        if ($pendingSessions) {
            return response()->json(['error' => 'There are pending sessions before this session.'], 400);
        }

        // Update the session status to processing
        $session = $this->sessionClass::where('teacher_id', $teacherId)
            ->where('id', $sessionId)
            ->first();

        if ($session) {
            $session->status = 'processing';
            $session->save();
            return response()->json(['message' => 'Session updated to processing.']);
        }

        return response()->json(['error' => 'Session not found.'], 404);
    }
}
