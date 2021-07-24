<?php
include_once "model/login.php";
include_once "model/customer.php";
include_once "model/verify.php";
include_once "../api/core/mail.php";



class Customer
{
    public function loginController($data = null)
    {
        include "lib/emails.php";

        $customer = new CustomerModel();
        $login = new CustomerLoginModel();

        $response = $customer->get($data);
        // Check if user is existing and verified
        if ($response && $response['is_verified'] == '1') {
            $otp = $login->createOTP($data);
            if ($otp) {
                $mail = new Mail();

                $success = $mail->send(
                    $data->email,
                    $CUSTOMER_OTP["subject"],
                    $CUSTOMER_OTP["html"] . "<p><b>" . $otp . "</b></p>",
                    $CUSTOMER_OTP["text"] . $otp
                );
                if ($success) {
                    $response = array("success" => true, "response" => 'OTP has been sent. Please check your email.');
                } else {
                    $response = array("success" => false, "response" => 'Error processing request');
                }
            } else {
                $response = array("success" => false, "response" => 'Error processing request');
            }
        } else if ($response) {
            // If not verified, will send verification link
            $code = $login->createCode($data);
            if ($code) {
                $mail = new Mail();

                $verificationURL = server::getURL() . '/verification?email=' . $data->email . '&code=' . $code;
                $success = $mail->send(
                    $data->email,
                    $CUSTOMER_EMAIL["subject"],
                    $CUSTOMER_EMAIL["html"] . '<a href="' . $verificationURL . '">' . $verificationURL . '</a>',
                    $CUSTOMER_EMAIL["text"] . $verificationURL
                );
                if ($success) {
                    $response = array("success" => true, "response" => 'Verification link has been sent. Please check your email.');
                } else {
                    $response = array("success" => false, "response" => 'Error processing request');
                }
            } else {
                $response = array("success" => false, "response" => 'Error processing request');
            }
        } else {
            // If not existing, will save the email and send verification link
            $code = $customer->create($data);
            if ($code) {
                $mail = new Mail();
                $verificationURL = server::getURL() . '/verification?email=' . $data->email . '&code=' . $code;
                $success = $mail->send(
                    $data->email,
                    $CUSTOMER_EMAIL["subject"],
                    $CUSTOMER_EMAIL["html"] . '<a href="' . $verificationURL . '">' . $verificationURL . '</a>',
                    $CUSTOMER_EMAIL["text"] . $verificationURL
                );
                if ($success) {
                    $response = array("success" => true, "response" => 'Verification link has been sent. Please check your email.');
                } else {
                    $response = array("success" => false, "error" => 'Error processing request');
                }
            } else {
                $response = array("success" => false, "error" => 'Error processing request');
            }
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
