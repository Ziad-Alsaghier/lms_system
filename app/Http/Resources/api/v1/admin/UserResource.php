<?php

namespace App\Http\Resources\api\v1\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        parent::toArray($request);
        return array_merge([
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when($this->role === 'teacher', $this->email),
            'sessions' => $this->when($this->role === 'teacher', $this->teacherSessions),
            'avatar' => $this->getAvatarUrl($this->avatar),
            'role' => $this->role,
            'phone' => $this->phone,
            'address' => $this->address,
            'category' => $this->category,
            'status' => $this->status,
            'sessionCount' => $this->role == 'student' ? $this->studentSessionsEnded->count() :
            $this->countTeacherSessionsEnded->count(),
            'created_at' => $this->created_at?->format('Y-m-d'),
            'updated_at' => $this->updated_at?->format('Y-m-d'),
        ], $this->role === 'student' ? [
            'parent_phone' => $this->parent_phone,
            'payment_method' => $this->payment_method,
            'age' => $this->age,
            'sessionsLimite' => $this->sessionsLimite,
            'price' => $this->price,
            'subscription' => $this->package
        ] : []);
    }
}
