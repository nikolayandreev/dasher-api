<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class SubscriptionRequest extends FormRequest
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
            'plan'           => 'required|in:start,pro',
            'payment_method' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'payment_method' => 'Проблем с дебитната/кредитната карта!',
            'plan.required'  => 'Проблем с избраният план!',
            'plan.in'        => 'Избраният план е невалиден!',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
