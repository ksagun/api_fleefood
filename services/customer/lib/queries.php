<?php
$GET_CUSTOMER           = "SELECT
                            c.id,
                            c.email,
                            vc.is_verified
                            FROM customers c
                            INNER JOIN user_verification_code vc
                            ON vc.customer_id = c.id
                            WHERE c.email = :email";

$SAVE_CUSTOMER_OTP         = "UPDATE customers
                                SET access_code = :otp
                                WHERE email = :email";

$SAVE_CUSTOMER_CODE   = "INSERT INTO user_verification_code(customer_id, verification_code) VALUES(:customerId, :code)";

$CREATE_CUSTOMER        = "INSERT INTO customers(email) VALUES(:email)";

$VERIFY_CUSTOMER_OTP    = "SELECT email,contact FROM customers WHERE email = :email AND access_code = :otp";

$VERIFY_CUSTOMER_EMAIL  = "UPDATE user_verification_code vc
                            JOIN customer c
                            ON vc.customer_id = c.id
                            SET vc.is_verified = '1'
                            WHERE c.email = :email
                            AND vc.verification_code = :code";
