<?php 
    require_once "../api/lib/vendor/autoload.php";
    use \Firebase\JWT\JWT;

    class JWTTokenizer{

        private $data;
        private $secret;

        public function __construct($data){
            $this->data = json_decode($data);
            $this->secret = 'FFS-API-128roote9OU-EN!@C1943';
        }

        public function generateJWT()
        {
            $payload = array(
                "iat" => time(),
                "exp" => time() + (60 * 60),
                "iss" => "http://localhost/fleefood/api",
                "data"=> array(
                    "email" => $this->data[0]->email,
                    "phone" => $this->data[0]->contact
                )
            );
            
            return JWT::encode($payload, $this->secret, 'HS256');
        }

        public function validateJWT($jwt)
        {
            //$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
            if ( preg_match('/Bearer\s(\S+)/', $jwt, $matches)) {
                 $jwt = $matches[1];
            }else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Token not found in request';
                exit;
            }

            $token = $jwt;

            if($token){
                try{
                    $decode  = JWT::decode($token, $this->secret, array('HS256'));
                    return array("success" => true, "payload" => $decode->data);
                }catch(Exception $err){
                    return array("success" => false, "error" => $err->getMessage());
                }
            }
        }
    }
?>