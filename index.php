<?php 
    include_once 'core/request.php';
    include_once 'core/router.php';
    include_once 'services/user/User.php';

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

    $app->route(Request::post("create"), function($req, $data){
        if($req){
            $user = new User();
            $user->createUserController($data);
        }
    });


?>