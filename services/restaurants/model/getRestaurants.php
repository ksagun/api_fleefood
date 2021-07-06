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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array("error" => "no data");
        }
    }
    public function getRestaurantMenu($params = null)
    {
        include "../api/services/restaurants/lib/queries.php";

        $location = $params['location'];
        $id = $params['id'];
        $conn = $this->connection();
        $stmt = $conn->prepare($GET_RESTAURANT_MENU);
        $stmt->bindParam(":location", $location);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return array("error" => "no data");
        }
    }
}