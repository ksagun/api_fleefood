<?php 
    require_once "../api/lib/db.php";
    
    class LoginModel extends DB{
       
        public function loginUserByEmail($data = null)
        {
            include "../api/services/user/lib/queries.php";

            $conn = $this->connection();
            $stmt = $conn->prepare($LOGIN_USER_EMAIL);
            $stmt->bindParam(":password", $data->password);
            $stmt->bindParam(":email", $data->email);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return array("success" => true, "response" => $stmt->fetchAll(PDO::FETCH_ASSOC));
            }else{
                return array("success" => false ,"error" => "Email or password is incorrect");
            }
        }

        public function loginUserByPhone($data = null)
        {
            include "../api/services/user/lib/queries.php";

            $conn = $this->connection();
            $stmt = $conn->prepare($LOGIN_USER_NUMBER);
            $stmt->bindParam(":password", $data->password);
            $stmt->bindParam(":number", $data->number);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return array("success" => true, "response" => $stmt->fetchAll(PDO::FETCH_ASSOC));
            }else{
                return array("success" => false ,"error" => "Phone or password is incorrect");
            }
        }
    }
