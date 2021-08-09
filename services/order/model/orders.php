<?php
require_once "../api/lib/db.php";

class OrderModel extends DB
{
    public function create($data = null)
    {
        include "../api/services/order/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($CREATE_ORDER);
        $stmt->bindParam(':customer_id', $data->customer_id);
        $stmt->bindParam(':item_id', $data->item_id);
        $stmt->bindParam(':quantity', $data->quantity);
        $stmt->bindParam(':order_date', $data->order_date);

        if ($stmt->execute()) {
            return array("success" => true);
        } else {
            return array("success" => false);
        }
    }
    public function getAll($data = null)
    {
    }
}
