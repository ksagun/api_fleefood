<?php 
    include_once "model/getUser.php";

    class User{
        
        public function userController($id = null)
        {
            $user = new UserModel();
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
    }

?>