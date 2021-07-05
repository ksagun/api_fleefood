<?php
include_once "model/getStash.php";
require_once "../api/classes/cinput.php";

class FoodStash{
    public function foodStashController($location = null){
        $stash = new FoodStashModel();
        $location = cinput::input($location);
        echo json_encode($stash->getFoodStash($location));
    }

    public function submitEntry($data = null){
        $stash = new FoodStashModel();
        $data->food_stash_id = cinput::input($data->stashid);
        $data->firstname = cinput::input($data->firstname);
        $data->lastname = cinput::input($data->lastname);
        $data->email = cinput::input($data->email);
        $data->contact = cinput::input($data->contact);
        $data->address1 = cinput::input($data->address1);
        $data->address2 = cinput::input($data->address2);
        $data->reason = cinput::input($data->reason);

        if($stash->getExistingStashEntry($data)){
            echo json_encode(array("success" => false, "msg"=> "You already submitted an entry, please comeback when there's a new stash!."));
        } else{
            echo json_encode($stash->submitEntry($data));
        }
        
    }
}



?>