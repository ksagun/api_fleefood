<?php
include_once "model/getRestaurants.php";
require_once "../api/classes/uuid.php";
require_once "../api/classes/cinput.php";
require_once "../api/classes/gmaps.php";
require_once "../api/classes/opstreetmaps.php";

class Restaurant{
    public function restaurantsController($params = null){
        
        //$gmaps = new GMAPS('AIzaSyBPeOdJGsMZ6mgsNN5FGFGQdM0SA-Y6l0M');
        //$gmaps->reverseGeocode($location);

        $opst = new OPSTMAPS();
        $uuid = new UUID();
        $list = new RestaurantModel();
        $params['location'] = cinput::input($params['location']);
        $locationArray = [];

        $data = $list->getRestaurantList($params['location']);
        
        //Loop through data and encode id
        if($data["success"]){

            try{
                foreach($data['data'] as &$row){
                    //Encoding ID
                    $row['id'] = $uuid->encode($row['id']);
    
                    //Geocoding address 
                    $result = $opst->geocode($row['address_line_2']." ".$row['municipality']." ".$row["city"]." ".$row["province"]);
                    if($result){
                        $result = json_decode($result);
                        //Create new property for coordinates result
                        $row['coordinates'] = array("lng" => $result->features[0]->geometry->coordinates[0], "lat" => $result->features[0]->geometry->coordinates[1]);
                    }
                }
                
                array_push($locationArray, [$params['lng'], $params['lat']]);
    
                foreach($data['data'] as &$row){
                    array_push($locationArray, [$row['coordinates']['lng'], $row['coordinates']['lat']]);
                }
    
                $matrixresult = $opst->distanceMatrix($locationArray);
                if($matrixresult){
                    $matrixresult = json_decode($matrixresult);
                    
                    array_shift($matrixresult->distances);
                    array_shift($matrixresult->durations);
                    
                    $count = 0;
                    foreach($data['data'] as &$row){
                        $count++;
                        $row['distance'] = $matrixresult->distances[$count - 1][0];
                        $row['duration'] = $matrixresult->durations[$count - 1][0];
                    }
                }
            }catch(Exception $e){
                echo $e->getMessage();
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
                $row['itemId'] = $uuid->encode($row['itemId']);
            }
        }

        echo json_encode($data['data']);
    }
}
