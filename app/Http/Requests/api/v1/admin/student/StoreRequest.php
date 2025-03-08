<?php

namespace App\Http\Requests\api\v1\admin\student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
              // This Function For Create Student
            'username'=>['required','string', 'unique:users,username'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'role'=>['sometime','string', 'in:teacher,admin', 'default:student'],
            'address'=>['required','string'],
            'parent_phone'=>['required','string'],
            'payment_method'=>['required','string', 'in:0,1,2'],
            'category'=>['required','string'],    
            'sessionCount'=>['sometimes','integer'],
            'subscription'=>['required','string'],  
            'status'=>['sometimes','string', 'in:active,inactive', 'default:active'],
            // 'phone'=>['required','min:6'],
            // 'age'=>['required','integer'],
            // 'email'=>['required','email', 'unique:users,email'],

            ];
    }
}
