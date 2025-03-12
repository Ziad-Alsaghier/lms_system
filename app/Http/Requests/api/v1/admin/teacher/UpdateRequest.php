<?php

namespace App\Http\Requests\api\v1\admin\teacher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
            //
               'name'=>['sometimes','string'],
               'email'=>['sometimes','email'],
               'password'=>['sometimes','min:6'],
               'avatar' => ['sometimes', 'image', 'max:2048'],
               'role'=>['sometimes','string', 'in:teacher,admin', 'default:admin'],
               'phone'=>['sometimes','min:6'],
               'address'=>['sometimes','string'],
               'status'=>['sometimes','in:active,inactive'],
        ];
    }
}
