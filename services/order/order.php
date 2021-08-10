<?php
include_once "model/orders.php";
require_once "../api/core/jwt.php";
require_once "../api/classes/cinput.php";

class Order
{
    public function createOrderController($data = null)
    {
        $jwt = new JWTTokenizer(null);
        $response = $jwt->validateJWT($_SERVER['HTTP_AUTHORIZATION']);

        if ($response['success']) {
            $data->email = $response["payload"]->email;
            $data->item_id = cinput::input($data->item_id);
            $data->quantity = cinput::input($data->quantity);
            // $data->order_date = cinput::input($data->order_date);

            $data->order_date = date("Y-m-d H:i:s");

            $order = new OrderModel();
            echo json_encode($order->create($data));
        } else {
            http_response_code(401);
        }
    }
    public function ordersController($params = null)
    {
    }
}
