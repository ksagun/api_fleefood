<?php 
include_once "model/getRestaurants.php";
require_once "../api/classes/uuid.php";
require_once "../api/classes/cinput.php";

class Restaurant{
    public function restaurantsController($location = null){
        echo $location;
        $uuid = new UUID();
        $list = new RestaurantModel();
        $location = cinput::input($location);
        $data = $list->getRestaurantList($location);

        //Loop through data and encode id
        if($data["success"]){
            foreach($data as &$row){
                $row['id'] = $uuid->encode($row['id']);
            }    
        }
       
        echo json_encode($data);
    }

}
?>