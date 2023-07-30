<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Interfaces\OtpInterface;
use App\Models\User;
use App\Services\GeneralServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'Success' => false,
                'Message' => 'The provided credentials are incorrect.',
            ], 401);
        }
        return response()->json([
            'Success' => true,
            'Message' => 'Login Successful',
            'Data' => [
                'token' => $user->createToken($request->device_name)->plainTextToken,
                'user' => $user
            ]
        ], 200);
        // return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'Success' => true,
            'Message' => 'Logout Successful',
        ], 200);
    }
    
    public function forgotPassword(Request $request,OtpInterface $otp)
    {
        $type = 'forgot_password';
        $otp_interface = config('services.otp.interface');
        $user = User::where($otp_interface, $request->$otp_interface)->first();
        if (! $user) {
            return response()->json([
                'Success' => false,
                'Message' => 'The provided credentials are incorrect.',
            ], 401);
        }
        $resend = $request->resend;
        if($resend){
            $otp_response = $otp->resendOtp($user,$type);
            $data = [
                'token' => $otp_response['token'],
                'otp' => $otp_response['otp']
            ];
            return response()->json([
                'success' => $otp_response['success'],
                'Message' => $otp_response['message'],
                'Data' => $data
            ], $otp_response['status']);
        }
      
        $service = new GeneralServices();
        $otp_response = $otp->sendOtp($user, $service->generateUniqueOTP(), $type);
        $data = ['token' => $otp_response['token']];
        if($otp_response['success'] && config('services.otp.debug')){
            $data['otp'] = $otp_response['otp'];
        }
        return response()->json([
            'success' => $otp_response['success'],
            'Message' => $otp_response['message'],
            'Data' => $data,

        ], $otp_response['status']);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $user_id = $request->user()->id;
        $user = User::where('id',$user_id)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'Success' => true,
            'Message' => 'Password Reset Successful',
            'Title' => 'Success'
        ], 200);
    }
}
