<?php
require_once "../api/lib/db.php";

class OrderModel extends DB
{
    public function create($data = null)
    {
        include "../api/services/order/lib/queries.php";
        try {
            $conn = $this->connection();
            $stmt = $conn->prepare($CREATE_ORDER);
            $stmt->bindParam(':email', $data->email);
            $stmt->bindParam(':item_id', $data->item_id);
            $stmt->bindParam(':quantity', $data->quantity);
            $stmt->bindParam(':order_date', $data->order_date);

            if ($stmt->execute()) {
                return array("success" => true, "response" => "order has been submitted");
            } else {
                return array("success" => false, "error" => "failed to create order");
            }
        } catch (\Exception $th) {
            return array("success" => false, "error" => "failed to create order");
        }
    }
    public function getAll($data = null)
    {
    }
}
