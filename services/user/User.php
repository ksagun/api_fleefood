<?php 
    include_once "model/getUser.php";
    include_once "model/login.php";
    require_once "../api/core/jwt.php";
    require_once "../api/classes/cinput.php";

    class User{
        
        public function userController($id = null)
        {
            $user = new UserModel();
            $id = cinput::input($id);
            echo json_encode($user->getUser($id));
        }

        public function usersController()
        {
            $user = new UserModel();
            echo json_encode($user->getUsers());
        }

        public function createUserController($data)
        {
            $user = new UserModel();

            $isUserExist = $user->getExistingUser($data);

            if($isUserExist['success']){
                echo json_encode($user->createUser($data));
            } else {
                echo json_encode($isUserExist);
            }   
        }

        public function getLoggedInUserController()
        {
            $user = new UserModel();
            $jwt = null;
            $jwt = new JWTTokenizer(null);
            $response = $jwt->validateJWT($_SERVER['HTTP_AUTHORIZATION']);
            echo json_encode($user->getLoggedInUser($response["payload"]->email));
        }

        public function loginController($data)
        {
            $user = new LoginModel();
            $jwt = null;
            
            if($data->type == 'email'){
                $response = $user->loginUserByEmail($data);
                if($response["success"] == true){
                    $jwt = new JWTTokenizer(json_encode($response['response']));
                    echo json_encode(array("success" => $response['success'], "jwt" => $jwt->generateJWT()));
                } else {
                    echo json_encode($response);
                }

            } elseif($data->type == 'phone'){
                $response = $user->loginUserByPhone($data);
                if($response["success"] == true){
                    $jwt = new JWTTokenizer(json_encode($response['response']));
                    echo json_encode(array("success" => $response['success'], "jwt" => $jwt->generateJWT()));
                } else {
                    echo json_encode($response);
                }
            } else {
                http_response_code(401);
            }
        }
    }

?>