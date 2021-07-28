<?php
include_once "model/searchMerchants.php";

class Search
{
    public function merchantsController($location = null)
    {
        $location = cinput::input($location);
        $merchants = new SearchMerchantsModel();
        echo json_encode($merchants->getLocations($location));
    }
}
