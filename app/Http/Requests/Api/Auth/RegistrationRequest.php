<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed',
            // TODO: Decide on password validation min
        ];
    }


    public function messages()
    {
        return [
            'first_name.required' => 'Задължително поле!',
            'first_name.min' => 'Поне 3 символа.',
            'last_name.required' => 'Задължително поле!',
            'last_name.min' => 'Поне 3 символа.',
            'email.required' => 'Задължително поле!',
            'email.email' => 'Невалиден Email адрес!',
            'email.unique' => 'Този Email адрес е зает от друг потребител!',
            'password.required' => 'Задължително поле!'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
