<?php
require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/classes/code.php";
require_once "../api/classes/server.php";

class CustomerLoginModel extends DB
{
    public function createOTP($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($SAVE_CUSTOMER_OTP);
        $otp = code::generateOTP();
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":otp", $otp);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return  $otp;
        } else {
            return null;
        }
    }
    public function createCode($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($SAVE_CUSTOMER_CODE);
        $code = code::generateVerificationCode();
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":code", $code);
        $stmt->execute();


        if ($stmt->rowCount() > 0) {
            return $code;
        } else {
            return null;
        }
    }
}
