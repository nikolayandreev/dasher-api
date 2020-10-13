<?php

namespace App\Http\Requests\Api\Cruds;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ServiceRequest extends FormRequest
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
            'vendor_id'   => 'required|integer',
            'category_id' => 'nullable|integer',
            'name'        => 'required|string',
            'price'       => 'required|numeric',
            'duration'    => 'required|integer',
            'is_active'   => 'nullable',
        ];
    }


    public function messages()
    {
        return [
            'vendor_id.required'  => 'Липсва vendor_id в заявката, този инцидент ще бъде докладван.',
            'vendor_id.integer'   => 'Липсва vendor_id в заявката, този инцидент ще бъде докладван.',
            'category_id.integer' => 'ID-то на категорията не изглежда правилно',
            'name.required'       => 'Задължително поле!',
            'price.required'      => 'Задължително поле!',
            'duration.required'   => 'Задължително поле!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
