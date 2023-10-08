<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends ApiRequest
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
        $rules =[
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|unique:users,email',
            'country' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ];
        if(request()->type == 'vendor')
        {
            $rules['vendor_company_id'] = 'required|exists:vendor_companies,id';
        }
        return $rules;

    }
}
