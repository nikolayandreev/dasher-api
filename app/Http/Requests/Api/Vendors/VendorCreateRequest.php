<?php

namespace App\Http\Requests\Api\Vendors;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VendorCreateRequest extends FormRequest
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
            'name'    => 'required',
            'area_id'    => 'required|integer',
            'street'     => 'required',
            'additional' => 'nullable',
        ];
    }


    public function messages()
    {
        return [
            'name.required'      => 'Задължително поле!',
            'area_id.required' => 'Задължително поле!',
            'area_id.integer'  => 'Трябва да съдържа само цифри!',
            'street.required'  => 'Задължително поле!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
