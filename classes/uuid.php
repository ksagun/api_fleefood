<?php 

class UUID{
    private $encryptMethod = 'AES-256-CBC';
    private $secretKey = 'ffs-128-serve';
    private $secretIV = 'ffs-127-order';

    public function encode($sid = null){
        $key = hash('sha256', $this->secretKey);
        $iv = substr((hash('sha256', $this->secretIV)), 0, 16);
        return base64_encode(openssl_encrypt($sid, $this->encryptMethod, $key, 0, $iv));;
    }


    public function decode($sid = null){
        $key = hash('sha256', $this->secretKey);
        $iv = substr((hash('sha256', $this->secretIV)), 0, 16);
        return openssl_decrypt(base64_decode($sid), $this->encryptMethod, $key, 0, $iv);

    }
}

?>