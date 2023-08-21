<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VendorCategoryRegisterRequest;
use App\Http\Requests\VendorCompanyAddressRegisterRequest;
use App\Http\Requests\VendorCompanyDetailsRegisterRequest;
use App\Http\Requests\VendorCompanyLogoRegisterRequest;
use App\Http\Requests\VendorCompanySignatureRegisterRequest;
use App\Interfaces\FileStorageInterface;
use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\OtpInterface;
use App\Models\Otp;
use App\Models\VendorCompany;
use App\Services\GeneralServices;

class RegisterController extends Controller
{
    protected $storage_path;
    public function __construct()
    {
        $this->middleware('guest');
        $this->storage_path = 'vendor/company/';
    }
    /**
     * Display a listing of the resource.
     */
    public function index(RegisterRequest $request, OtpInterface $otp)
    {

        try {
            $user = User::create($request->except('vendor_company_id'));
            //send otp to verify email
            if($request->type == 'vendor')
            {
                $vendor = VendorCompany::find($request->vendor_company_id);
                $vendor->update(['user_id' => $user->id]);
            }
            $type = 'register';
            $service = new GeneralServices();
            $otp_response = $otp->sendOtp($user, $service->generateUniqueOTP(), $type);
            if (!$otp_response['success']) {
                // remove the user from database
                $user->delete();
                $data = ['token' => $otp_response['token']];
                return response()->json([
                    'Success' => $otp_response['success'],
                    'Message' => $otp_response['message'],
                    'Title'   => $otp_response['title'],
                    'Data' => $data,
                ], $otp_response['status']);
            }
            $data = ['token' => $otp_response['token']];
                
            if(config('services.otp.debug') && $otp_response['success'])
            {
                $data['otp'] = $otp_response['otp'];
            }
            return response()->json([
                'Success' => $otp_response['success'],
                'Message' => $otp_response['message'],
                'Title'   => $otp_response['title'],
                'Data' => $data,
            ], $otp_response['status']);
        } catch (\Exception $e) {
            $user->delete();
            return response()->json([
                'Success' => false,
                'Message' => $e->getMessage(),
                'Title'   => 'Error',
                'Data' => [],
            ], 500);
        }
    }

    public function vendorCategory(VendorCategoryRegisterRequest $request)
    {
        $vendorCompany = VendorCompany::create($request->all());
        $vendor_company_id = $vendorCompany->id;
        
        return response()->json([
            'Success' => true,
            'Message' => 'Vendor Category Registered Successfully',
            'Title'   => 'Success',
            'Data' => ['vendor_company_id' => $vendor_company_id],
        ], 200);
    }

    public function vendorCompanyAddress(VendorCompanyAddressRegisterRequest $request) {
        $vendor_company_id = $request->vendor_company_id;
        $vendorCompany = VendorCompany::find($vendor_company_id);
        $vendorCompany->update($request->except(['vendor_company_id']));
        return response()->json([
            'Success' => true,
            'Message' => 'Vendor Company Details Registered Successfully',
            'Title'   => 'Success',
            'Data' => ['vendor_company_id' => $vendor_company_id],
        ], 200);
    }

    public function vendorCompanyDetails(VendorCompanyDetailsRegisterRequest $request) {
        $vendor_company_id = $request->vendor_company_id;
        $vendorCompany = VendorCompany::find($vendor_company_id);
        $vendorCompany->update($request->safe()->except(['vendor_company_id']));
        return response()->json([
            'Success' => true,
            'Message' => 'Vendor Company Details Registered Successfully',
            'Title'   => 'Success',
            'Data' => ['vendor_company_id' => $vendor_company_id],
        ], 200);
    }

    public function vendorCompanyLogo(VendorCompanyLogoRegisterRequest $request,FileStorageInterface $storage)
    {
        $vendor_company_id = $request->vendor_company_id;
        $vendorCompany = VendorCompany::find($vendor_company_id);
        $logoPath = $storage->saveFile($request->file('logo'), $this->storage_path.$vendor_company_id,'logo.'.$request->file('logo')->extension());
        $signaturePath = $storage->saveFile($request->file('signature'), $this->storage_path.$vendor_company_id,'signature.'.$request->file('signature')->extension());
        
        $logoUrl = config('app.url').$storage->getFileUrl($logoPath);
        $signatureUrl = config('app.url').$storage->getFileUrl($signaturePath);
        $vendorCompany->update(['logo' => $logoPath,'signature' => $signaturePath]);
        return response()->json([
            'Success' => true,
            'Message' => 'Vendor Company Logo & Signature Uploaded Successfully',
            'Title'   => 'Success',
            'Data' => ['vendor_company_id' => $vendor_company_id, 'logo' => $logoUrl, 'signature' => $signatureUrl],
        ], 200);
    }
    public function vendorCompanySignature(VendorCompanySignatureRegisterRequest $request,FileStorageInterface $storage)
    {
        $vendor_company_id = $request->vendor_company_id;
        $vendorCompany = VendorCompany::find($vendor_company_id);
        // $signaturePath = $storage->saveFile($request->file('signature'), $this->storage_path.$vendor_company_id,);
        $signaturePath = $storage->saveFile($request->file('signature'), $this->storage_path.$vendor_company_id,'signature.'.$request->file('signature')->extension());
        $signatureUrl = config('app.url').$storage->getFileUrl($signaturePath);
        $vendorCompany->update(['signature' => $signaturePath,'signature' => $signaturePath]);

        return response()->json([
            'Success' => true,
            'Message' => 'Vendor Company Signature Uploaded Successfully',
            'Title'   => 'Success',
            'Data' => ['vendor_company_id' => $vendor_company_id,'signature' => $signatureUrl],
        ], 200);
    }
}
