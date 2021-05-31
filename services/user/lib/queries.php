<?php
    $GET_USER = "SELECT username,email,contact FROM users WHERE id = :id";
    $GET_USERS = "SELECT username,email,contact FROM users";
    $GET_EXISTING_USER = "SELECT username, email FROM users WHERE username = :username AND email = :email";
    $CREATE_USER = "INSERT INTO users(username,password,email,contact) VALUES(:username, :password, :email, :contact)";
    $LOGIN_USER_EMAIL = "SELECT email, contact FROM users WHERE password = :password AND email = :email";
    $LOGIN_USER_NUMBER = "SELECT email, contact FROM users WHERE password = :password AND contact = :number";
    $GET_LOGGED_USER_BY_EMAIL = "SELECT email, contact, username FROM users WHERE email = :email";
?>