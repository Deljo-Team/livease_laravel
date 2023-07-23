<?php

namespace App\Http\Requests;

use App\Exceptions\CompanyNotIdentifiedException;
use App\Models\VendorCompany;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

class VendorCompanyDetailsRegisterRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $vendor_company_id = request()->vendor_company_id;
        $vendor_company = VendorCompany::find($vendor_company_id);
        if (!$vendor_company) {
            return false;
        }
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
            'company_type' => 'required|string',
            'phone_code' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ];
    }
    protected function failedAuthorization()
    {
        throw new CompanyNotIdentifiedException();
        parent::failedAuthorization();
    }
}
