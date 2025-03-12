<?php

namespace App\Http\Resources\api\v1\teacher;

use App\Http\Resources\api\v1\student\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrentSession extends JsonResource
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
            'Session_id' => $this->id,
            'start' => $this->start,
            'end' => $this->end,
            'active' => $this->active,
            'student' => new Student($this->student) ,
            'teacher' => $this->teacher,
            'status' => $this->status,
        ];
    }
}
