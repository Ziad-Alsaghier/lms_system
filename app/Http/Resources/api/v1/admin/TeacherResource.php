<?php

namespace App\Http\Resources\api\v1\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         parent::toArray($request);
                // Return Teacher Data For Admin
         return [
                'id' => $this->id,
                'username' => $this->username,
                'email' => $this->email,
                'avatar' => $this->avatar,  
                'role' => $this->role,
                'phone' => $this->phone,
                'address' => $this->address,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
        ];
    }
}
