<?php
require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/core/otp.php";

class CustomerLoginModel extends DB
{
    public function loginCustomer($data = null)
    {
        include "../api/services/customer/lib/queries.php";
        include "../api/services/customer/lib/emails.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($LOGIN);
        $otp = otp::generate();
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":otp", $otp);
        $stmt->execute();
        $mail = new Mail();

        if ($stmt->rowCount() > 0) {
            $customer = $stmt->fetch(PDO::FETCH_ASSOC);
            $success = $mail->send(
                $customer['email'],
                $CUSTOMER_OTP["subject"],
                $CUSTOMER_OTP["html"] . "<p><b>" . $otp . "</b></p>",
                $CUSTOMER_OTP["text"] . $otp
            );
            if ($success) {
                return array("success" => true, "response" => 'OTP has been sent. Please check your email.');
            }
            return array("success" => false, "error" => 'Error processing request');
        } else {
            $verificationURL = "/verification?email=" . $data->email . "c";
            $success = $mail->send(
                $customer->email,
                $VERIFY_EMAIL["subject"],
                $VERIFY_EMAIL["html"] . '<p><a href="' . $verificationURL . '">' . $verificationURL . '</a></p>',
                $VERIFY_EMAIL["text"] . $verificationURL
            );
            if ($success) {
                return array("success" => true, "response" => 'Please check your email for verification.');
            }
            return array("success" => false, "error" => 'Error processing request');
        }
    }
    public function verifyOTP($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($VERIFY_OTP);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":otp", $data->otp);
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
        $stmt = $conn->prepare($VERIFY_EMAIL);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":otp", $data->otp);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return array("success" => true, "response" => $stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            return array("success" => false, "error" => "OTP verification failed.");
        }
    }
}
