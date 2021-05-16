<?php 
 require_once "../api/lib/db.php";

class FoodStashModel extends DB{
  
    public function getFoodStash($location = null){
        include "../api/services/food-stash/lib/queries.php";

        $location = '%'.$location.'%';
        $conn = $this->connection();
        $stmt = $conn->prepare($GET_FOOD_STASH_DATA);
        $stmt->bindParam(":location", $location);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return array("error" => "no data");
        }
    }

    public function submitEntry($data = null){
        include "../api/services/food-stash/lib/queries.php";

        $conn = $this->connection();
        $stmt = $conn->prepare($INSERT_FOOD_STASH_ENTRY);
        $stmt->bindParam(":stashid", $data->stashid);
        $stmt->bindParam(":firstname", $data->firstname);
        $stmt->bindParam(":lastname", $data->lastname);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":contact", $data->contact);
        $stmt->bindParam(":address1", $data->address1);
        $stmt->bindParam(":address2", $data->address2);
        $stmt->bindParam(":reason", $data->reason);

        if($stmt->execute()){
            return array("success" => true);
        }else {
            return array("success" => false);
        }
    }

   
}







?>