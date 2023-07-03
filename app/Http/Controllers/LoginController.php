<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
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
                'success' => 0,
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }
        return response()->json([
            'success' => 1,
            'message' => 'Login Successful',
            'token' => $user->createToken($request->device_name)->plainTextToken,
            'user' => $user
        ], 200);
        // return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => 1,
            'message' => 'Logout Successful',
        ], 200);
    }
    
    public function forgotPassword(Request $request,OtpInterface $otp)
    {
        $type = 'forgot_password';
        $otp_interface = config('services.otp.interface');
        $user = User::where($otp_interface, $request->$otp_interface)->first();
        if (! $user) {
            return response()->json([
                'success' => 0,
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }
        $resend = $request->resend;
        if($resend){
            $otp_response = $otp->resendOtp($user,$type);
            return response()->json([
                'success' => $otp_response['success'],
                'message' => $otp_response['message'],
                'token' => $otp_response['token'],
            ], $otp_response['status']);
        }
      
        $service = new GeneralServices();
        $otp_response = $otp->sendOtp($user, $service->generateUniqueOTP(), $type);
        return response()->json([
            'success' => $otp_response['success'],
            'message' => $otp_response['message'],
            'token' => $otp_response['token'],
        ], $otp_response['status']);
    }
}
