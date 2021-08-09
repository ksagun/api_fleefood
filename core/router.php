<?php 

    class Router{

        public function route($url, $callback){
            if(isset($url['method']) && $url['method'] != null && $_GET['url'] == $url['url']){
                //Get query string params
                $queryString = explode('&',$_SERVER['QUERY_STRING']);
                
                //Get post body
                $postBody = file_get_contents("php://input");
                $data = json_decode($postBody);

                //Get mulitiple path
                $rawurl = parse_url($_SERVER['REQUEST_URI']);
                $urlmap = $rawurl["path"];

                //Removes /fleefood/api
                $path = array_slice(explode('/',$urlmap), 3);

                $params = null;
                
                if(count($queryString) > 2){
                    $query = $_GET;
                    //Returns all query params in array
                    $params = array_slice($query, 1); 
                    return $callback->__invoke($_GET['url'], $params);
                } else if($data != NULL){
                    return $callback->__invoke($_GET['url'], $data);
                } else if(count($path) > 1){
                    $path = array_splice($path, 1);
                    return $callback->__invoke($_GET['url'], $path);
                } else if(count($queryString) > 2 && count($path) > 1){
                   return $callback->__invoke($_GET['url'], [$params, $queryString]);
                } else {
                   return $callback->__invoke($_GET['url']);
                }
            }
        }
    }
