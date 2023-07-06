<?php

namespace App\Http\Requests;

use App\Http\Requests\ApiRequest;

class OtpRequest extends ApiRequest
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
        if(config('services.otp.interface') == 'email'){
            return [
                'email' => 'required|email',
                'resend' => 'required|boolean',
                'type' => 'required|string',
                'device_name' => 'required|string'
            ];
        }elseif(config('services.otp.interface') == 'phone'){
            return [
                'phone' => 'required|numeric',
                'resend' => 'required|boolean',
                'type' => 'required|string',
                'device_name' => 'required|string'

            ];
        }
        
    }
}
