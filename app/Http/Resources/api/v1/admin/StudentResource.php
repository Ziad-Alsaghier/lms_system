<?php

namespace App\Http\Resources\api\v1\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
                'id' => $this->id,
                'username' => $this->username,
                'email' => $this->email,
                'avatar' => $this->avatar,  
                'role' => $this->role,
                'phone' => $this->phone,
                'address' => $this->address,
                'parent' => $this->parent,
                'payment_method' => $this->payment_method,
                'age' => $this->age,
                'created_at' => $this->created_at->format('Y-m-d'),
                'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
