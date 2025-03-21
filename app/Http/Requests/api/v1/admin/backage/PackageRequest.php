<?php

namespace App\Http\Requests\api\v1\admin\backage;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PackageRequest extends FormRequest
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
            // This Is All Name Request 
            'name'=>['sometimes'],
            'sessionCount'=>['sometimes'],
            'price'=>['sometimes'],
            'status' => ['sometimes', 'string', 'in:active,inactive'],
        ];
    }

     public function failedValidation(Validator $validator)
    {
        foreach ($validator->errors() as $key => $value) {
            $errors =  $validator->errors()->add($key, $value);
            throw new ValidationException(response()->json([$key=>$errors],400));
        }
        
    }

}
