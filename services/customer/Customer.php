<?php
include_once "model/login.php";

class Customer
{
    public function loginController($data = null)
    {

        $customer = new CustomerLoginModel();
        $jwt = null;

        $response = $customer->loginCustomer($data);
        if ($response["success"]) {
            $jwt = new JWTTokenizer(json_encode($response['response']));
            echo json_encode(array("success" => $response['success'], "jwt" => $jwt->generateJWT()));
        } else {
            echo json_encode($response);
        }
    }
}
