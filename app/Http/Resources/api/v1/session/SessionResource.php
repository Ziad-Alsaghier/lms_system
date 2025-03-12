<?php

namespace App\Http\Resources\api\v1\session;

use App\Http\Resources\api\v1\admin\StudentResource;
use App\Http\Resources\api\v1\admin\TeacherResource;
use App\Http\Resources\api\v1\admin\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         parent::toArray($request);
        return [
            'id' => $this?->id,
            'date' => $this?->date,
            'start' => $this?->session_date,
            'end' => $this?->session_time,
            'active' => $this?->active,
            'status' => $this?->status,
            'teacher' => new UserResource($this?->teacher),
            'student' => new UserResource($this?->student),
            // 'student' => new StudentResource($this?->student),
            'created_at' => $this?->created_at,
            'updated_at' => $this?->updated_at          
        ];
    }
}
