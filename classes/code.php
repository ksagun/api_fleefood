<?php
class code
{
    public static function generateOTP()
    {
        $otp = rand(000000, 999999);
        return $otp;
    }

    public static function generateVerificationCode()
    {
        $bytes = openssl_random_pseudo_bytes(4, $cstrong);
        if (!$bytes) {
            // fallback
            return code::generateOTP();
        }
        return bin2hex($bytes);
    }
}
