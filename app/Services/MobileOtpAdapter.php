<?php

namespace App\Services;

use App\Interfaces\OtpInterface;
use Models\User;

class MobileOtpAdapter implements OtpInterface
{
   function sendOtp($user, $otp)
   {
      return "token";
   }
   function verifyOtp($token, $otp): int
   {
      return 1;
   }
   function resendOtp($user)
   {
      return 1;
   }
}
