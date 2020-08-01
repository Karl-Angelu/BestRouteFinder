<?php 

class Point{
    private $helper;
    private $conn;
    private $table="points";

    public $name;
    public $connects_to;
    public $connects_from;
    
    private $created_id;
    private $connect_to_id;
    private $deleted_id;

    public function __construct($db){
    $this->conn = $db;
    $this->helper = new Helper($db);
    }
    
    public function read(){
        $query = "SELECT * FROM ".$this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
        
    }
    public function create(){
        
        $query = "INSERT INTO ".$this->table." SET 
                name=:name";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(':name',$this->name);

        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:/n'.$stmt->error);
        return false;
    }
    public function update(){
        $query = "UPDATE ".$this->table." SET
                name = :name
                WHERE
                id=:id";
      
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        

        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':id',$this->id);

        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:/n'.$stmt->error);
        return false;

    }
    public function delete(){
        // find deleted_id
        $this->helper->find = $this->name;
        $this->helper->table = $this->table;
        $this->helper->find_field = "id";
        $this->helper->where_field="name";
        $this->helper->find();
        $this->deleted_id = $this->helper->found;
       
        // delete point
        $this->helper->find_name = $this->name;
        $this->helper->table = $this->table;
        $this->helper->where_field = "name";

        if($this->helper->delete_point()){
            // delete route with from_point_id = deleted_point_id
            $this->helper->find_id = $this->deleted_id;
            $this->helper->table = "routes";
            $this->helper->where_field = "from_point_id";
            $this->helper->delete_route();

            // delete route with to_point_id = deleted_point_id
            $this->helper->find_id = $this->deleted_id;
            $this->helper->table = "routes";
            $this->helper->where_field = "to_point_id";

            if($this->helper->delete_route()){
                return true;
            }else{
                printf('Error: %s:\n'.$stmt->error);
                return false;
            }

            
        }
        printf('Error: %s:\n'.$stmt->error);
        return false;

    }
    
}