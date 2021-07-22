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
        // Check if user is existing and verified
        if ($response && $response['is_verified'] == '1') {
            $response = $login->sendOTP($data);
        } else if ($response) {
            // If not verified, will send verification link
            $response = $login->sendVerification($data);
        } else {
            // If not existing, will save the email and send verification link
            $response = $customer->create($data);
        }
        echo json_encode($response);
    }
    public function verifyController($params = null)
    {
        $verification = new CustomerVerifyModel();
        $jwt = null;


        $params['email'] = cinput::input($params['email']);

        if (isset($params['code'])) {
            $params['code'] = cinput::input($params['code']);
            $params['type'] = 'code';
        } else {
            $params['otp'] = cinput::input($params['otp']);
            $params['type'] = 'otp';
        }

        if ($params['type'] == 'code') {
            $response = $verification->verifyEmail($params);
            echo json_encode($response);
        } else if ($params['type'] == 'otp') {
            $response = $verification->verifyOTP($params);
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
