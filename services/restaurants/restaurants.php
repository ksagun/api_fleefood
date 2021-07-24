<?php
include_once "model/getRestaurants.php";
require_once "../api/classes/uuid.php";
require_once "../api/classes/cinput.php";

class Restaurant{
    public function restaurantsController($location = null){
    
        $uuid = new UUID();
        $list = new RestaurantModel();
        $location = cinput::input($location);
        $data = $list->getRestaurantList($location);

        //Loop through data and encode id
        if($data["success"]){
            foreach($data['data'] as &$row){
                $row['id'] = $uuid->encode($row['id']);
            }    
        }
       
        echo json_encode($data["data"]);
    }
    public function restaurantController($params = null)
    {
        $uuid = new UUID();
        $list = new RestaurantModel();
        $params['name'] = cinput::input($params['name']);
        $params['id'] = $uuid->decode(cinput::input($params['id']));

        $data = $list->getRestaurantMenu($params);

        if (isset($data["success"]) && $data['success']) {
            foreach ($data['data'] as &$row) {
                $row['id'] = $uuid->encode($row['id']);

                foreach($row['menu'] as &$items){
                    $items['itemId'] = $uuid->encode($items['itemId']);
                }
            }
        }

        echo json_encode($data['data']);
    }
}
