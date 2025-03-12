<?php

namespace App\Http\Resources\api\v1\admin;

use App\Http\Resources\api\v1\teacher\CurrentSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
      private $token; // Store the token

      // Accept the token when creating the resource
      public function withToken($token)
      {
      $this->token = $token;
      return $this;
      }
    public function toArray(Request $request): array
    {
         parent::toArray($request);
                // Return Teacher Data For Admin
         return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'phone' => $this->phone,
                'status' => $this->status,
                'address' => $this->address,
                'sessionCount' => $this->teacherSessions->count(),
                'avatar' => $this->getAvatarUrl(),
                'token' => $this->when(isset($this->token), $this->token->token ?? Null), // Include token if available
                'sessions' => $this->getCurrentMonthSessions(),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
        ];
    }

    public function getCurrentMonthSessions()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $sessions = $this->teacherSessions()
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->get();

        $daysWithSessions = [];

        // Ensure Carbon date copying to avoid mutation issues
        for ($date = $startOfMonth->copy(); $date->lte($endOfMonth); $date->addDay()) {
            $day = $date->format('Y-m-d');
            
            // Match using Carbon to prevent format mismatch
            $daySessions = $sessions->filter(function ($session) use ($day) {
                return Carbon::parse($session->date)->format('Y-m-d') == $day;
            });

            $daysWithSessions[] = [
                'date' => $day,
                'sessions' => $daySessions->isNotEmpty()
                    ? CurrentSession::collection($daySessions)
                    : [],
            ];
        }

        return $daysWithSessions;
    }
}
