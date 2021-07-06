<?php
include_once "model/getRestaurants.php";
require_once "../api/classes/uuid.php";
require_once "../api/classes/cinput.php";

class Restaurant
{
    public function restaurantsController($location = null)
    {
        $uuid = new UUID();
        $list = new RestaurantModel();
        $location = cinput::input($location);
        $data = $list->getRestaurantList($location);

        //Loop through data and encode id
        foreach ($data as &$row) {
            $row['id'] = $uuid->encode($row['id']);
        }

        echo json_encode($data);
    }
    public function restaurantController($params = null)
    {
        $list = new RestaurantModel();
        $params['location'] = cinput::input($params['location']);
        $params['id'] = cinput::input($params['id']);
        echo json_encode($list->getRestaurantMenu($params));
    }
}
