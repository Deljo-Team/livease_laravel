<?php

namespace App\Http\Requests;

use App\Exceptions\CompanyNotIdentifiedException;
use App\Models\VendorCompany;


class VendorCompanyAddressRegisterRequest extends ApiRequest
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

    protected function failedAuthorization()
    {
        throw new CompanyNotIdentifiedException();
        parent::failedAuthorization();
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
            'latitude' => 'required',
            'longitude' => 'required',
        ];
    }
}
