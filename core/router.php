<?php 

    class Router{

        public function route($url, $callback){
            if($url['method'] != null && $_GET['url'] == $url['url']){
                $queryString = explode('&',$_SERVER['QUERY_STRING']);
                
                $postBody = file_get_contents("php://input");
                $data = json_decode($postBody);

                if(count($queryString) > 2){
                    $query = $_GET;
                    $params = array_slice($query, 1); 
                    return $callback->__invoke($_GET['url'], $params);
                } else if($data != NULL){
                    return $callback->__invoke($_GET['url'], $data);
                } else {
                    return $callback->__invoke($_GET['url']);
                }
            }
        }
    }


?>