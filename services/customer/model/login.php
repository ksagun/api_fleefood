<?php
require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/classes/code.php";
require_once "../api/classes/server.php";

class CustomerLoginModel extends DB
{
    public function saveOTP($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        try {
            $conn = $this->connection();
            $stmt = $conn->prepare($SAVE_CUSTOMER_OTP);
            $stmt->bindParam(":email", $data->email);
            $stmt->bindParam(":otp", $data->otp);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return  true;
            } else {
                return false;
            }
        } catch (\Exception $th) {
            return false;
        }
    }
    public function saveCode($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        try {
            $conn = $this->connection();
            $stmt = $conn->prepare($SAVE_CUSTOMER_CODE);
            $stmt->bindParam(":email", $data->email);
            $stmt->bindParam(":code", $data->code);
            $stmt->execute();


            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $th) {
            return false;
        }
    }
}
