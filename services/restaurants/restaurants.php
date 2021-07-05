<?php
include_once "model/getRestaurants.php";
require_once "../api/classes/cinput.php";

class Restaurant
{
    public function restaurantsController($location = null)
    {
        $list = new RestaurantModel();
        $location = cinput::input($location);
        echo json_encode($list->getRestaurantList($location));
    }
    public function restaurantController($params = null)
    {
        $list = new RestaurantModel();
        $params['location'] = cinput::input($params['location']);
        $params['id'] = cinput::input($params['id']);
        echo json_encode($list->getRestaurantMenu($params));
    }
}
