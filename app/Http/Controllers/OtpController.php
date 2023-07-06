<?php

namespace App\Http\Controllers;

use App\Http\Requests\OtpRequest;
use App\Http\Requests\OtpVerificationRequest;
use App\Models\Otp;
use Illuminate\Http\Request;
use App\Services\GeneralServices;
use App\Models\User;
use App\Interfaces\OtpInterface;


class OtpController extends Controller
{
    public function sendOtp(OtpRequest $request,OtpInterface $otp)
    {
        $type = $request->type;
        $otp_interface = config('services.otp.interface');
        $user = User::where($otp_interface, $request->$otp_interface)->first();
        if (! $user) {
            return response()->json([
                'Success' => false,
                'Message' => 'The provided credentials are incorrect.',
                'Title' => 'Error'
            ], 401);
        }
        $resend = $request->resend;
        if($resend){
            $otp_response = $otp->resendOtp($user,$type);
            return response()->json([
                'Success' => $otp_response['success'],
                'Message' => $otp_response['message'],
                'Title' => $otp_response['title'],
                'Data' => ['token' => $otp_response['token']],
            ], $otp_response['status']);
        }
      
        $service = new GeneralServices();
        $otp_response = $otp->sendOtp($user, $service->generateUniqueOTP(), $type);
        return response()->json([
            'Success' => $otp_response['success'],
            'Message' => $otp_response['message'],
            'Title' => $otp_response['title'],
            'Data' => ['token' => $otp_response['token']],
        ], $otp_response['status']);
    }

    public function verifyOtp(OtpVerificationRequest $request,OtpInterface $otpService)
    {
        $token = $request->token;
        $otp = $request->otp;
        $type = $request->type;
        $otp_response = $otpService->verifyOtp($token,$otp,$type);
        if($otp_response['success'] && $type == 'register'){
            $user = User::where('id',$otp_response['user_id'])->first();
            $user->createToken($request->device_name)->plainTextToken;
        }
        return response()->json([
            'Success' => $otp_response['success'],
            'Message' => $otp_response['message'],
            'Title' => $otp_response['title'],
        ], $otp_response['status']);
    }
}
