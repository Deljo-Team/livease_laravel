<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorCategoryRegisterRequest extends ApiRequest
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
          'categories' => 'required|array|min:1',
          'categories.*' => 'required|exists:categories,id',
          'sub_categories' => 'required|array|min:1',
          'sub_categories.*' => 'required|exists:sub_categories,id',
        ];
    }
}
