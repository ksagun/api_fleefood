<?php

use PHPMailer\PHPMailer\Exception;

require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/classes/code.php";

class CustomerModel extends DB
{
    public function get($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($GET_CUSTOMER);
        $stmt->bindParam(":email", $data->email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        try {
            $conn = $this->connection();
            $conn->beginTransaction();

            $stmt = $conn->prepare($CREATE_CUSTOMER);
            $stmt->bindParam(":email", $data->email);
            $stmt->execute();

            $customerId = $conn->lastInsertId();

            $code = code::generateVerificationCode();

            $stmt = $conn->prepare($SAVE_CUSTOMER_CODE);
            $stmt->bindParam(":customerId", $customerId);
            $stmt->bindParam(":code", $code);
            $stmt->execute();

            $conn->commit();

            return array("success" => true, "response" => 'OTP has been sent. Please check your email.');
        } catch (Exception $th) {
            $conn->rollBack();
            return array("success" => false, "error" => 'Error processing request');
        }
    }
}
