<?php

namespace App\Http\Resources\api\v1\student;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Student extends JsonResource
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
            'name' => $this->name,
            'role' => $this->role,
            'address' => $this->address,
            'parent_phone' => $this->parent_phone,
            'subscription' => $this->package,
            'payment_method' => $this->payment_method,
        ];
        }
}
