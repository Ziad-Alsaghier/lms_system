<?php

namespace App\Http\Requests\api\v1\admin\session;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class SessionClassRequest extends FormRequest
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
            // This Function For Create Session
            'student_id'=>['required', 'exists:users,id'],
            'teacher_id'=>['required', 'exists:users,id'],
            'day'=>['sometimes', 'string', 'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday'],
            'status'=>['sometimes', 'string', 'in:pending,processing,done,cancelled'],
            'active' => ['sometimes', 'string', 'in:active,inactive'],
            'category'=>['sometimes', 'string'],
            'package_id'=>['sometimes', 'exists:packages,id'],
            'date' => ['required', 'date_format:Y-m-d'], // YYYY-MM-DD

        ];
    }

      public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json(
            ['message'=>$validator->errors()], 422));
    }
}
