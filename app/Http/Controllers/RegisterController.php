<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Interfaces\OtpInterface;
use App\Services\GeneralServices;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RegisterRequest $request, OtpInterface $otp)
    {
        $user = User::create($request->validated());
        //send otp to verify email
        $type = $request->type;
        $service = new GeneralServices();
        $otp_response = $otp->sendOtp($user,$service->generateUniqueOTP(),$type);
        return response()->json([
            'success' => $otp_response['success'],
            'message' => $otp_response['message'],
            'token' => $otp_response['token'],
        ], $otp_response['status']);
        
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
