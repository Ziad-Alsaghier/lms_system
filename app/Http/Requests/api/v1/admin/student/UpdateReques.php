<?php

namespace App\Http\Requests\api\v1\admin\student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateReques extends FormRequest
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
            // This Function For Update Student
              'username'=>['sometimes','string', 'unique:users,username'],
              'email'=>['sometimes','email', 'unique:users,email'],
              'avatar' => ['nullable', 'image', 'max:2048'],
              'role'=>['sometime','string', 'in:teacher,admin', 'default:student'],
              'phone'=>['sometimes','min:6'],
              'address'=>['sometimes','string'],
              'parent'=>['sometimes','string'],
             'payment_method' => ['sometimes', 'string', 'in:0,1,2'],
              'age'=>['sometimes','integer'],
              'status'=>['sometimes','string', 'in:active,inactive', 'default:active'],
        ];
    }
}
