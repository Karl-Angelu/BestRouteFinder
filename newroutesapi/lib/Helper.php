<?php

class Helper{

    private $conn;

    public $find;
    public $find_name;
    public $found_id;
    public $table;
    public $where_field;
    public $find_field;

    public function __construct($db){
        $this->conn = $db;
        }
    public function find(){
      
        $findquery = "SELECT ".$this->find_field." FROM ".$this->table." WHERE ".$this->where_field."=:find";
        $findstmt = $this->conn->prepare($findquery);
        $findstmt->bindParam(':find',$this->find);
        $findstmt->execute();
        $find= $findstmt->fetch(PDO::FETCH_ASSOC);
        $this->found= $find[$this->find_field];
    }

    public function delete_point(){
        $deletequery = "DELETE FROM ".$this->table." WHERE ".$this->where_field."=:find_name";
        $deletestmt = $this->conn->prepare($deletequery);
        $this->id = htmlspecialchars(strip_tags($this->find_name));
        $deletestmt->bindParam(':find_name',$this->find_name);
        if($deletestmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function delete_route(){
        $deletequery = "DELETE FROM ".$this->table." WHERE ".$this->where_field."=:find_id";
        $deletestmt = $this->conn->prepare($deletequery);
        $this->id = htmlspecialchars(strip_tags($this->find_id));
        $deletestmt->bindParam(':find_id',$this->find_id);
        if($deletestmt->execute()){
            return true;
        }else{
            return false;
        }
    }

}