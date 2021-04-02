<?php 
    
    class DB{
        public $user = 'root';
        public $password = '';
        public $host = 'localhost';
        public $db = 'fleefood';
        public $config;
        
        public function connection()
        {
            try {
                $conn = new PDO("mysql:host={$this->host};dbname={$this->db}", $this->user, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully";
                return $conn;
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
        }




    }
?>