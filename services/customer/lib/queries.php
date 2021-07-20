<?php
$LOGIN = "UPDATE customers SET access_code = :otp WHERE email = :email";
$SAVE_CUSTOMER_OTP = "UPDATE customers SET access_code = :otp WHERE email = :email";
$VERIFY_OTP = "SELECT email,contact FROM customers WHERE email = :email AND access_code = :otp";
$VERIFY_EMAIL = "SELECT email,contact FROM customers WHERE email = :email AND access_code = :otp";
$GET_CUSTOMER = "SELECT email,contact FROM customers WHERE id = :id";
$GET_CUSTOMERS = "SELECT email,contact FROM customers";
$GET_EXISTING_CUSTOMER = "SELECT email FROM customers WHERE email = :email";
$CREATE_CUSTOMER = "INSERT INTO customers(email,contact) VALUES(:email, :contact)";
$GET_LOGGED_CUSTOMER_BY_EMAIL = "SELECT email, contact FROM customers WHERE email = :email";
