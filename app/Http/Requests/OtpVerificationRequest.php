<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class OtpVerificationRequest extends ApiRequest
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
            'otp' => 'required|numeric',
            'token' => 'required|string',
            'type' => 'required|string'
        ];
    }
}
