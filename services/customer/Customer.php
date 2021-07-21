<?php
include_once "model/login.php";
include_once "model/customer.php";
include_once "model/verify.php";

class Customer
{
    public function loginController($data = null)
    {

        $customer = new CustomerModel();
        $login = new CustomerLoginModel();
        $response = $customer->get($data);
        if ($response && $response['is_verified'] == '1') {
            $response = $login->sendOTP($data);
        } else if ($response) {
            $response = $login->sendVerification($data);
        } else {
            $response = $customer->create($data);
        }
        echo json_encode($response);
    }
    public function verifyController($data = null)
    {
        $verification = new CustomerVerifyModel();
        $jwt = null;

        if ($data->type == 'code') {
            $response = $verification->verifyEmail();
            echo json_encode($response);
        } else if ($data->type == 'otp') {
            $response = $verification->verifyOTP();
            if ($response["success"] == true) {
                $jwt = new JWTTokenizer(json_encode($response['response']));
                echo json_encode(array("success" => $response['success'], "jwt" => $jwt->generateJWT()));
            } else {
                echo json_encode($response);
            }
        } else {
            http_response_code(401);
        }
    }
}
