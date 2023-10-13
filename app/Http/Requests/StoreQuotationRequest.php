<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends ApiRequest
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
            // 'quotation_number' => 'required|string',
            'service_id' => 'required|exists:services,id',
            'service_name' => 'required|string',
            'quotation_amount' => 'required|string',
            'site_inspection' => 'boolean',
            'status' => 'string',
            'signature' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
