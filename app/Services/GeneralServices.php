<?php

namespace App\Services;
use App\Models\Otp;

class GeneralServices
{
    public function generateUniqueOTP()
    {
        $digits = config('services.otp.length');
        // Generate a random OTP with the specified number of digits
        $otp = mt_rand(pow(10, $digits - 1), pow(10, $digits) - 1);

        // Check if the OTP already exists in the "otp" table
        $existingOtp = Otp::where('otp', $otp)->exists();

        // If the OTP already exists, generate a new one recursively
        if ($existingOtp) {
            return $this->generateUniqueOTP();
        }

        return $otp;
    }

    function slugify($input) {
        // Convert multiple spaces to single spaces
        $slug = preg_replace("/[[:blank:]]+/",' ', $input);
        // Convert to lower case
        $slug = strtolower($slug);
        // Remove anything that's not a number, letter or space
        $slug = preg_replace('/[^a-z0-9\s]+/', '', $slug);
        // Trim, and replace spaces with hyphens
        $slug = preg_replace('/\s/', '-', trim($slug));
    
        return $slug;
    }
    

}
