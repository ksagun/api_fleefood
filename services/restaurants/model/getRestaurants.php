<?php
require_once "../api/lib/db.php";

class RestaurantModel extends DB
{

    public function getRestaurantList($location = null)
    {
        include "../api/services/restaurants/lib/queries.php";
        $location = '%' . $location . '%';
        $conn = $this->connection();
        $stmt = $conn->prepare($GET_RESTAURANT_LIST_BY_LOCATION);
        $stmt->bindParam(":location", $location);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return array("data" => $stmt->fetchAll(PDO::FETCH_ASSOC), "success" => true);
        } else {
            return array("success" => false, "error" => "No data");
        }
    }

    public function getRestaurantMenu($params = null)
    {
        include "../api/services/restaurants/lib/queries.php";

        $storeName = $params['name'];
        $id = $params['id'];
        $conn = $this->connection();
        $stmt = $conn->prepare($GET_RESTAURANT_DETAILS);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $storeName);
        
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $menustmt = $conn->prepare($GET_RESTAURANT_MENU);
            $menustmt->bindParam(":id", $id);
            $menustmt->bindParam(":name", $storeName);
            $menustmt->execute();

            if($menustmt->rowCount() > 0){
                foreach($rows as &$row){
                    $row['menu'] = $menustmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
           
            return array("data" => $rows, "success" => true);
        } else {
            return array("success" => false, "error" => "No data");
        }
    }
}
