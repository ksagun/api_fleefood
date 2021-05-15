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

   
}







?>