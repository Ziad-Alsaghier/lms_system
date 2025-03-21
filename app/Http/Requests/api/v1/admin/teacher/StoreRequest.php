<?php

namespace App\Http\Requests\api\v1\admin\teacher;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the authenticated user has the 'admin' role
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
            // This Function For Create Teacher
            'name'=>['required','string', 'unique:users,name'],
            'email'=>['required','email', 'unique:users,email'],
            'password'=>['required','min:3'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'role'=>['sometimes','string', 'in:teacher,admin', 'default:teacher'],
            'phone'=>['required','min:3'],
            'address'=>['required','string'],
            'sessionLimit'=>['sometimes'],
            'status'=>['sometimes','string', 'in:active,inactive'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json(['message'=>$validator->errors()], 422));
    }
}
