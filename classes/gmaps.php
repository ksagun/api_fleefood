<?php 

class GMAPS{

    private $api_key = null;
    private $curl;
  
    public function __construct($key)
    {
        $this->api_key = $key;
        $this->curl = curl_init();
    }

    public function reverseGeocode($address){
        curl_setopt_array($this->curl, [
            CURLOPT_URL => "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=".$this->api_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ]);

        $response = curl_exec($this->curl);
        $err = curl_error($this->curl);

        curl_close($this->curl);

        if ($err) {
	        echo "cURL Error #:" . $err;
        } else {
	        echo $response;
        }
    
    }
}
?>