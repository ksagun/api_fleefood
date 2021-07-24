<?php 

require './lib/vendor/autoload.php';
use GuzzleHttp\Client;
use GuzzleHttp\Request;
use GuzzleHttp\Exception\GuzzleException;

/*API USED OPEN ROUTE SERVICE*/
class OPSTMAPS{

    private $api_key = null;
    private $client = null;
  
    public function __construct()
    {
        $this->api_key = '5b3ce3597851110001cf6248b9b9026be41543c6b9a2a3bf3a6744c88';
        $this->client = new Client();
    }

    public function geocode($address){
        $request = new \GuzzleHttp\Psr7\Request('GET', "https://api.openrouteservice.org/geocode/search?api_key=".$this->api_key."&text=".$address."&size=1");
        $promise = $this->client->sendAsync($request)->then(function ($response) {
           return $response->getBody();
        });

        return $promise->wait();
    }


    /*The Isochrone Service supports time and distance analyses for one single or multiple locations.
    You may also specify the isochrone interval or provide multiple exact isochrone range values.
    This service allows the same range of profile options as the /directions endpoint,
    which help you to further customize your request to obtain a more detailed reachability area response.*/
    public function isochrone($locations){
        $request = new \GuzzleHttp\Psr7\Request('POST', "https://api.openrouteservice.org/v2/isochrones/driving-car",
            [
                'Authorization' => $this->api_key
            ], 
            json_encode(array("locations" => $locations))
        );
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            return $response->getBody();
         });

         return $promise->wait();
    }

    public function distanceMatrix($locations){

        $body =  json_encode(array("locations" => $locations, "destinations" => [0], "metrics" => ['distance','duration'], "units" => "km"));
      
        $request = new \GuzzleHttp\Psr7\Request('POST', "https://api.openrouteservice.org/v2/matrix/driving-car",
            [
                'Authorization' => $this->api_key,
                'Content-Type' => 'application/json'
            ], 
           $body
        );
        $promise = $this->client->sendAsync($request)->then(function ($response) {
            return $response->getBody();
         });

         return $promise->wait();
    }
}
?>