<?php 
    require_once "../api/lib/db.php";
    
    class UserModel extends DB{
        
        public function getUser($id = null)
        {
            include "../api/services/user/lib/queries.php";

            $conn = $this->connection();
            $stmt = $conn->prepare($GET_USER);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }else{
                return array("error" => "no data");
            }
        }

        public function getUsers()
        { 
            include "../api/services/user/lib/queries.php";

            $conn = $this->connection();
            $stmt = $conn->prepare($GET_USERS);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return array("error" => "no data");
            }
        }

        public function getExistingUser($data = null)
        {
            include "../api/services/user/lib/queries.php";
            
            $conn = $this->connection();
            $stmt = $conn->prepare($GET_EXISTING_USER);
            $stmt->bindParam(":username", $data->username);
            $stmt->bindParam(":email", $data->email);
            $stmt->execute();

            if($stmt->rowCount() > 0){
                return array("success" => false, "message" => "There's already a user associated with this data");
            } else {
                return array("success" => true);
            }
        }

        public function createUser($data = null)
        {
            include "../api/services/user/lib/queries.php"; 
            
            $conn = $this->connection();
            $stmt = $conn->prepare($CREATE_USER);
            $stmt->bindParam(":username", $data->username);
            $stmt->bindParam(":password", $data->password);
            $stmt->bindParam(":email", $data->email);
            $stmt->bindParam(":contact", $data->contact);
            
            if($stmt->execute()){
                return array("success" => true);
            }else {
                return array("success" => false);
            }
        }
    }


?>