<?php

use PHPMailer\PHPMailer\Exception;

require_once "../api/lib/db.php";
require_once "../api/core/mail.php";
require_once "../api/classes/code.php";
require_once "../api/classes/server.php";

class CustomerModel extends DB
{
    public function get($data = null)
    {
        include "../api/services/customer/lib/queries.php";

        try {
            $conn = $this->connection();
            $stmt = $conn->prepare($GET_CUSTOMER);
            $stmt->bindParam(":email", $data->email);
            $stmt->execute();

            if ($stmt->rowCount()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
            return null;
        } catch (\Exception $th) {
            return null;
        }
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

            $stmt = $conn->prepare($CREATE_CUSTOMER_CODE);
            $stmt->bindParam(":customerId", $customerId);
            $stmt->bindParam(":code", $data->code);
            $stmt->execute();



            if ($stmt->rowCount() > 0 && $conn->commit()) {
                return true;
            }
            return false;
        } catch (\Exception $th) {
            $conn->rollBack();
            return false;
        }
    }
}
