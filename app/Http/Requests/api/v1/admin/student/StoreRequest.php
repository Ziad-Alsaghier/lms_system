<?php

namespace App\Http\Requests\api\v1\admin\student;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
            'role'=>['sometimes','string', 'in:teacher,admin', 'default:student'],
            'address'=>['required','string'],
            'parent_phone'=>['required','string'],
            'payment_method'=>['required','string', 'in:0,1,2'],
            'category'=>['required','string'],    
            'sessionCount'=>['sometimes','integer'],
            'subscription'=>['sometimes','string'],  
            'status'=>['sometimes','string', 'in:active,inactive'],
            'package_id'=>['sometimes', 'exists:packages,id'],
            // 'phone'=>['required','min:6'],
            // 'age'=>['required','integer'],
            // 'email'=>['required','email', 'unique:users,email'],

            ];
    }

     public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json($validator->errors(), 422));
    }
}
