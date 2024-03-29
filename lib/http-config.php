<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
     //header("Access-Control-Allow-Origin: *");
     header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Allow-Credentials: true");
     header("Access-Control-Max-Age: 3600");

     //COMMENT IF ALREADY TESTING WITH FRONTEND
     //header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
     //header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
          header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
     }

     if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
          header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
     }
     exit(0);
}
