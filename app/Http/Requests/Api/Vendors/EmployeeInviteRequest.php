<?php

namespace App\Http\Requests\Api\Vendors;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class EmployeeInviteRequest extends FormRequest
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
        $roles = Role::where('name', '!=', 'manager')->pluck('name');

        return [
            'vendor_id' => 'required|exists:vendors,id',
            'email'     => 'required|email',
            'role'      => 'required|' . Rule::in($roles),
        ];
    }


    public function messages()
    {
        return [
            'vendor_id.required' => 'Задължително поле!',
            'vendor_id.exists' => 'Няма такъв обект!',
            'email.required' => 'Задължително поле!',
            'email.email'    => 'Невалиден Email адрес!',
            'role.required'  => 'Задължително поле!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
