<?php 
 Class Database {
    private $host = "localhost";
    private $username = "root";
    private $pass = "";
    private $db = "newroutesdb";
    private $conn;

    public function connect(){
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db,$this->username,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error'.$e->getMessage();
        }
        return $this->conn;
    }

 }