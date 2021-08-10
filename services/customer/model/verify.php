<?php
require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/classes/code.php";

class CustomerVerifyModel extends DB
{
    public function verifyOTP($params = null)
    {
        include "../api/services/customer/lib/queries.php";
        try {
            $conn = $this->connection();
            $stmt = $conn->prepare($VERIFY_CUSTOMER_OTP);
            $stmt->bindParam(":email", $params['email']);
            $stmt->bindParam(":otp", $params['otp']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return array("success" => true, "response" => $stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                return array("success" => false, "error" => "OTP is incorrect.");
            }
        } catch (\Exception $th) {
            return array("success" => false, "error" => "Error processing request.");
        }
    }
    public function verifyEmail($params = null)
    {
        include "../api/services/customer/lib/queries.php";

        try {
            $conn = $this->connection();
            $stmt = $conn->prepare($VERIFY_CUSTOMER_EMAIL);
            $stmt->bindParam(":email", $params['email']);
            $stmt->bindParam(":code", $params['code']);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return array("success" => true, "response" => "Email verification successful. You may log in now.");
            } else {
                return array("success" => false, "error" => "Invalid verification link.");
            }
        } catch (\Exception $th) {
            return array("success" => false, "error" => "Error processing request.");
        }
    }
}
