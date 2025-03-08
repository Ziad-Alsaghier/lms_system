<?php

namespace App\Http\Resources\api\v1\admin;

use App\Http\Resources\api\v1\teacher\CurrentSession;
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
                'username' => $this->username,
                'email' => $this->email,
                'role' => $this->role,
                'phone' => $this->phone,
                'address' => $this->address,
                'subject' => $this->subject->name,
                'sessionCount' => $this->teacherSessions->count(),
                'avatar' => $this->getAvatarUrl(),
                'token' => $this->when(isset($this->token), $this->token->token), // Include token if available
                'current_session' => $this->getCurrentMonthSessions(),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
        ];
    }
}
