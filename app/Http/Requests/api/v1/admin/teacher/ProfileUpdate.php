<?php

namespace App\Http\Requests\api\v1\admin\teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check() && Auth::user()->role === 'teacher';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
             'username'=>['required','string', 'unique:users,username'],
             'email'=>['required','email', 'unique:users,email'],
             'password'=>['sometimes','min:3'],
             'avatar' => ['nullable', 'image', 'max:2048'],
             'role'=>['sometimes','string', 'in:teacher,admin', 'default:teacher'],
             'phone'=>['required','min:3'],
             'address'=>['required','string'],
             'status'=>['sometimes','string', 'in:active,inactive'],
        ];
    }
}
