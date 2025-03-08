<?php

namespace App\Http\Resources\api\v1\admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
           return [
                'id' => $this->id,
                'username' => $this->username,
                'email' => $this->email,
                'avatar' => $this->avatar,  
                'role' => $this->role,
                'token' => $this->when(isset($this->token), $this->token->token), // Include token if available
                'created_at' => $this->created_at->format('Y-m-d'),
                'updated_at' => $this->updated_at->format('Y-m-d'),
            
        ];
    }
}
