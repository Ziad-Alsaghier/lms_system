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
            'username'=>['required','string', 'unique:users,username'],
            'email'=>['required','email', 'unique:users,email'],
            'password'=>['required','min:6'],
            'avatar' => ['nullable', 'image', 'max:2048'],
            'role'=>['sometime','string', 'in:teacher,admin', 'default:admin'],
            'phone'=>['required','min:6'],
            'address'=>['required','string'],
            'subject_id'=>['required','exists:subjects,id'],
            'status'=>['sometimes','string', 'in:active,inactive', 'default:active'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json($validator->errors(), 422));
    }
}
