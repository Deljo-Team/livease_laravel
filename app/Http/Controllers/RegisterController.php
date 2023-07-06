<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\OtpInterface;
use App\Models\Otp;
use App\Services\GeneralServices;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RegisterRequest $request, OtpInterface $otp)
    {

        try {
            $user = User::create($request->all());
            //send otp to verify email

            $type = 'register';
            $service = new GeneralServices();
            $otp_response = $otp->sendOtp($user, $service->generateUniqueOTP(), $type);
            if (!$otp_response['success']) {
                // remove the user from database
                $user->delete();
                return response()->json([
                    'Success' => $otp_response['success'],
                    'Message' => $otp_response['message'],
                    'Title'   => $otp_response['title'],
                    'Data' => ['token' => $otp_response['token']],
                ], $otp_response['status']);
            }
            return response()->json([
                'Success' => $otp_response['success'],
                'Message' => $otp_response['message'],
                'Title'   => $otp_response['title'],
                'Data' => ['token' => $otp_response['token']],
            ], $otp_response['status']);
        } catch (\Exception $e) {
            $user->delete();
            Otp::where('user_id', $user->id)->where('type', $type)->delete();
            return response()->json([
                'Success' => false,
                'Message' => $e->getMessage(),
                'Title'   => 'Error',
                'Data' => [],
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
