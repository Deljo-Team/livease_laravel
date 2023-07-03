<?php 

namespace App\Interfaces;

interface OtpInterface
{
    public function sendOtp($to, $otp,$type);
    public function resendOtp($user,$type);
    public function verifyOtp($token, $otp,$type);
}

?>