<?php
class otp
{
    public static function generate()
    {
        $otp = rand(00000, 99999);
        return $otp;
    }
}
