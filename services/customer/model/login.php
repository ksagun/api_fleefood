<?php
require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/classes/code.php";

class CustomerLoginModel extends DB
{
    public function sendOTP($data = null)
    {
        include "../api/services/customer/lib/queries.php";
        include "../api/services/customer/lib/emails.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($SAVE_CUSTOMER_OTP);
        $otp = code::generateOTP();
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":otp", $otp);
        $stmt->execute();
        $mail = new Mail();

        if ($stmt->rowCount() > 0) {
            $success = $mail->send(
                $data->email,
                $CUSTOMER_OTP["subject"],
                $CUSTOMER_OTP["html"] . "<p><b>" . $otp . "</b></p>",
                $CUSTOMER_OTP["text"] . $otp
            );
            if ($success) {
                return array("success" => true, "response" => 'OTP has been sent. Please check your email.');
            }
            return array("success" => false, "error" => 'Error processing request');
        } else {
            return array("success" => false, "error" => 'Error processing request');
        }
    }
    public function sendVerification($data = null)
    {
        include "../api/services/customer/lib/queries.php";
        include "../api/services/customer/lib/emails.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($SAVE_CUSTOMER_CODE);
        $code = code::generateVerificationCode();
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":code", $code);
        $stmt->execute();

        $mail = new Mail();

        if ($stmt->rowCount() > 0) {
            $success = $mail->send(
                $data->email,
                $CUSTOMER_OTP["subject"],
                $CUSTOMER_OTP["html"] . "<p><b>" . $otp . "</b></p>",
                $CUSTOMER_OTP["text"] . $otp
            );
            if ($success) {
                return array("success" => true, "response" => 'OTP has been sent. Please check your email.');
            }
            return array("success" => false, "error" => 'Error processing request');
        } else {
            return array("success" => false, "error" => 'Error processing request');
        }
    }
}
