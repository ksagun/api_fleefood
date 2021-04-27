<?php 

    class cinput{

        public static function url($url){
            return filter_var($url, FILTER_SANITIZE_URL);
        }

        public static function input($input){
            $input = strval($input);
            return filter_var($input, FILTER_SANITIZE_STRING);
        }
        
        public static function payload($input){
            $input = json_decode(json_encode($input, true), true);
            
            foreach($input as $key => $value){
                $input[$key] = filter_var($value, FILTER_SANITIZE_STRING);
            }

            $input = json_decode(json_encode($input, false), false);
            
            return $input;
        }

        public static function email($email){
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        }
        
    }

?>