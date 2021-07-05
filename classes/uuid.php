<?php 

class UUID{
    private static $secret = "ffs-128-serve";

    public static function encode($sid = null){
        $s = base64_encode(self::$secret);
        $id = base64_encode($sid);
        $uuid = $s.'_'.$id;
        $encoded = base64_encode($uuid);
        return $encoded;
    }


    public static function decode($sid = null){
        $encoded = base64_decode($sid);
        $uuid = explode('_', $encoded);
        $s = base64_decode($uuid[0]);

        if($s == self::$secret){
            return base64_decode($uuid[1]);
        }
    }
}

?>