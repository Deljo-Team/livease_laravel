<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationApiRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'country_id' => 'required|exists:countries,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'country_id.required' => 'Country is required',
            'country_id.exists' => 'Country does not exist',
        ];
    }
}
