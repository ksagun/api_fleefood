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

        if ($stmt->rowCount())
            return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data = null)
    {
        include "../api/services/customer/lib/queries.php";
        include "../api/services/customer/lib/emails.php";

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


            if ($stmt->rowCount() > 0) {
                $mail = new Mail();
                $verificationURL = 'localhost/fleefood/api/verification?email=' . $data->email . '&code=' . $code;
                $success = $mail->send(
                    $data->email,
                    $CUSTOMER_EMAIL["subject"],
                    $CUSTOMER_EMAIL["html"] . '<a href="' . $verificationURL . '">' . $verificationURL . '</a>',
                    $CUSTOMER_EMAIL["text"] . $verificationURL
                );
                if ($success) {
                    return array("success" => true, "response" => 'Verification link has been sent. Please check your email.');
                }
                return array("success" => false, "error" => 'Error processing request');
            }
        } catch (Exception $th) {
            $conn->rollBack();
            return array("success" => false, "error" => 'Error processing request');
        }
    }
}
