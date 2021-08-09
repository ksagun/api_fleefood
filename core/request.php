<?php
class Request
{
    public static function get($url)
    {
        $x = filter_var($url, FILTER_SANITIZE_URL);
        $path = [];
        echo $x . "\n";

        if (strpos($url, "/")) {
            $path = explode("/", $url);
            var_dump($path);
        }

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return array("url" => $x, "method" => 'GET');
        }
    }

    public static function post($url)
    {
        $x = filter_var($url, FILTER_SANITIZE_URL);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return array("url" => $x, "method" => 'POST');
        }
    }

    public static function patch($url)
    {
        $x = filter_var($url, FILTER_SANITIZE_URL);

        if ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
            return array("url" => $x, "method" => 'PATCH');
        }
    }

    public static function delete($url)
    {
        $x = filter_var($url, FILTER_SANITIZE_URL);

        if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
            return array("url" => $x, "method" => 'DELETE');
        }
    }
}
