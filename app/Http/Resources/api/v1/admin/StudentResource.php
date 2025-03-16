<?php

namespace App\Http\Resources\api\v1\admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    private $token; // Store the token
        
    public function toArray(Request $request): array
    {
         parent::toArray($request);
        return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'avatar' => $this->getAvatarUrl($this->avatar),
                'role' => $this->role,
                'phone' => $this->phone,
                'address' => $this->address,
                'parent_phone' => $this->parent_phone,
                'category' => $this->category,
                'status' => $this->status,
                'sessionsLimite' => $this->sessionsLimite,
                'payment_method' => $this->payment_method,
                'age' => $this->age,
                'sessionCount' => $this->studentSessions->count(),
                'subscription' => $this->package,
                'price' => $this->price,
                'created_at' => $this->created_at?->format('Y-m-d'),
                'updated_at' => $this->updated_at?->format('Y-m-d'),
        ];
    }

     public function failedValidation(Validator $validator)
     {
     throw new ValidationException($validator, response()->json(
     ['message'=>$validator->errors()], 422));
     }
}
