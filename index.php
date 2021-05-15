<?php 
    include_once 'core/request.php';
    include_once 'core/router.php';
    include_once 'services/user/User.php';
    include_once 'core/jwt.php';
    include_once 'lib/endpoints.php';
    include_once 'classes/cinput.php';

    //ALWAYS INCLUDE FOR CORS CONFIGURATION
    include_once 'lib/http-config.php';

    if(!in_array(cinput::url($_GET['url']), $auth_endpoints)){
        $jwt = new JWTTokenizer(null);
    
        $response = $jwt->validateJWT($_SERVER['HTTP_AUTHORIZATION']);
        if(!$response["success"]){
            echo json_encode(array("success" => false, "error" => $response["error"]));
            exit;
        }
    }
   
    
    $app = new Router();
    
    $app->route(Request::get("user"), function($req, $params){
        if($req){
            $user = new User();
            $user->userController($params['id']);
        }
    });

    $app->route(Request::get("users"), function($req){
        if($req){
            $user = new User();
            $user->usersController();
        }
    });

    $app->route(Request::get("agent"), function($req){
        if($req){
            $user = new User();
            $user->getLoggedInUserController();
        }
    });

    $app->route(Request::post("create"), function($req, $data){
        if($req){
            $user = new User();
            $user->createUserController($data);
        }
    });

    $app->route(Request::post("login"), function($req, $data){
        if($req){
            $user = new User();
            $user->loginController($data);
        }
    });

    $app->route(Request::get("stack"), function($req, $data){
        if($req){
            var_dump($data);
        }
    });

?>