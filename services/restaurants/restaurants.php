<?php 
include_once "model/getRestaurants.php";
require_once "../api/classes/uuid.php";
require_once "../api/classes/cinput.php";

class Restaurant{
    public function restaurantsController($location = null){
        $list = new RestaurantModel();
        $location = cinput::input($location);
        $data = $list->getRestaurantList($location);

        //Loop through data and encode id
        foreach($data as &$row){
            $row['id'] = UUID::encode($row['id']);
        }

        echo json_encode($data);
    }

}
?>