<?php 
    class Request{
        public static function get($url) {
            $x = filter_var($url, FILTER_SANITIZE_URL);

            if($_SERVER['REQUEST_METHOD'] == 'GET')
            {
                return array("url" => $x, "method" => 'GET');
            } 
        }

        public static function post($url) {
            $x = filter_var($url, FILTER_SANITIZE_URL);

            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                return array("url" => $x, "method" => 'POST');
            }
        }
    }
?>