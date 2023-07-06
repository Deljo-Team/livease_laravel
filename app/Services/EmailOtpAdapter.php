<?php

namespace App\Services;

use App\Interfaces\OtpInterface;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use App\Models\Otp;

class EmailOtpAdapter implements OtpInterface
{
  

  function sendOtp($user, $otp,$type)
  {

    $token =  Crypt::encryptString($otp);
    //delete all the previous otps
    Otp::where('user_id', $user->id)->whereNot('otp', $otp)->delete();
    $otp_response = Otp::create([
      'user_id' => $user->id,
      'token' => $token,
      'otp' => $otp,
      'type' => $type,
      'is_used' => false,
      'expires_at' => now()->addMinutes(config('services.otp.expiry'))
    ]);
    if (!$otp_response) {
      //send the email
      return [
        'success' => false,
        'title' => 'Error',
        'message' => 'OTP not sent',
        'token' => '',
        'status' => 500
      ];
    }
    Mail::to($user->email)->send(new OtpMail($otp,$type));
    return [
      'success' => true,
      'message' => 'OTP sent successfully',
      'title' => 'Success',
      'token' => $token,
      'status' => 200
    ];
  }
  function verifyOtp($token, $otp, $type)
  {
    $otpData = Otp::where('token', $token)->first();
        if (! $otpData ) {
            return [
                'success' => false,
                'title' => 'Error',
                'message' => 'The provided credentials are incorrect.',
                'status' => 401
            ];
        }
        if($otpData->is_used){
          return [
              'success' => false,
              'title' => 'Error',
              'message' => 'OTP Already Used',
              'status'  => 401
          ];
      }
        if($otpData->expires_at < now()){
            return [
                'success' => false,
                'title' => 'Error',
                'message' => 'OTP Expired',
                'status'  => 401
            ];
        }
        if($otpData->otp != $otp){
            return [
                'success' => false,
                'title' => 'Error',
                'message' => 'OTP not matched',
                'status' => 401
            ];
        }
        $otpData->is_used = true;
        $otpData->save();
        $user = $otpData->user;
        if($type == 'register'){
            $user->is_email_verified = true;
            $user->save();
        }
        return [
            'success' => true,
            'message' => 'OTP Verified',
            'title' => 'Success',
            'status' => 200
        ];
  }
  function resendOtp($user,$type)
  {
    $status = true;
    $otp = Otp::where('user_id', $user->id)->where('type',$type)->first();
    if(!$otp){
      $message = 'OTP not found';
      $status = false;
      $title = 'Error';
      return [
        'success' => $status,
        'message' => $message,
        'title' => $title,
        'token' => '',
        'status' => 200
      ];
    }
    if($otp->attempts > config('services.otp.attempts')){
      $message = 'OTP attempts exceeded';
      $status = false;
      $title = 'Error';
    }
    if (now() > $otp->expires_at ) {
      $otp->delete();
      $message = 'OTP expired';
      $status = false;
      $title = 'Error';
    }
    if($otp->is_used){
      $message = 'OTP already used';
      $status = false;
      $title = 'Error';
    }
    if($status == false){
      return [
        'success' => $status,
        'message' => $message,
        'title' => $title,
        'token' => '',
        'status' => 200
      ];
    }
    $otp->attempts = $otp->attempts + 1;
    $otp->save();
    Mail::to($user->email)->send(new OtpMail($otp->otp,$type));
    return [
      'success' => true,
      'message' => 'OTP sent successfully',
      'title' => 'Success',
      'token' => $otp->token,
      'status' => 200
    ];
  }
}
