<?php
    $GET_USER = "SELECT username,email,contact FROM users WHERE id = :id";
    $GET_USERS = "SELECT username,email,contact FROM users";
    $GET_EXISTING_USER = "SELECT username, email FROM users WHERE username = :username AND email = :email";
    $CREATE_USER = "INSERT INTO users(username,password,email,contact) VALUES(:username, :password, :email, :contact)";
?>