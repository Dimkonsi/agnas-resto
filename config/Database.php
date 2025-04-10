<?php 

class Database{
    private $host = "Localhost" ;
    private $db_name = "resto_db";
    private $username = "root";
    private $password = "";
    public $conn;

    public function getConnetion(){
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function closeConnection(){
        if($this->conn){
            $this->conn->close();
        }
    }
}

?>