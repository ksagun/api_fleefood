<?php
include_once "model/getStash.php";
require_once "../api/classes/cinput.php";

class FoodStash{
    public function foodStashController($location = null){
        $stash = new FoodStashModel();
        $location = cinput::input($location);
        echo json_encode($stash->getFoodStash($location));
    }
}



?>