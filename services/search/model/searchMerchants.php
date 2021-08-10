<?php
require_once "../api/lib/db.php";

class SearchMerchantsModel extends DB
{

    public function getLocations($location = null)
    {
        include "../api/services/search/lib/queries.php";
        $location = '%' . $location . '%';
        try {
            $conn = $this->connection();
            $stmt = $conn->prepare($GET_MERCHANTS_LOCATION);
            $stmt->bindParam(":location", $location);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = array_unique($stmt->fetchAll(PDO::FETCH_ASSOC), SORT_REGULAR);
                return array("data" => $data, "success" => true);
            } else {
                return array("success" => false, "error" => "No data");
            }
        } catch (\Exception $th) {
            return array("success" => false, "error" => "No data");
        }
    }
}
