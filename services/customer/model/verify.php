<?php
require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/classes/code.php";

class CustomerVerifyModel extends DB
{
    public function verifyOTP($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($VERIFY_CUSTOMER_OTP);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":otp", $data['otp']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return array("success" => true, "response" => $stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            return array("success" => false, "error" => "OTP is incorrect.");
        }
    }
    public function verifyEmail($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($VERIFY_CUSTOMER_EMAIL);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":code", $data['code']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return array("success" => true, "response" => "Email verification successful. You may log in now.");
        } else {
            return array("success" => false, "error" => "Email verification failed.");
        }
    }
}
