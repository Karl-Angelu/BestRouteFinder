<?php 

class Route{
    private $conn;
    private $firstTable="routes";
    private $secondTable="points";
    private $from_point_id;
    private $to_point_to;

    // Post fields
    public $id;
    public $origin;
    public $destination;
    public $bestroute;
    public $from_point;
    public $to_point;
    public $time;
    public $cost;

    public function __construct($db){
    $this->conn = $db;
    $this->helper = new Helper($db);
    }
    
    public function read(){
        $query = "SELECT r.to_point_id,v.name,r.time,r.cost FROM ".$this->firstTable." r INNER JOIN ".$this->secondTable." v ON r.to_point_id=v.id WHERE from_point_id=:id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$this->id);
        $stmt->execute();
        return $stmt;
        
    }
    public function read_all(){
        $query = "SELECT * FROM ".$this->firstTable;

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',$this->id);
        $stmt->execute();

        return $stmt;

    }
    public function create(){

        $this->helper->find = $this->from_point;
        $this->helper->table = $this->secondTable;
        $this->helper->where_field="name";
        $this->helper->find_field="id";
        $this->helper->find();
        $this->from_point_id = $this->helper->found;
        
        $this->helper->find = $this->to_point;
        $this->helper->table = $this->secondTable;
        $this->helper->where_field="name";
        $this->helper->find_field="id";
        $this->helper->find();
        $this->to_point_id = $this->helper->found;

        $insertquery = "INSERT INTO ".$this->firstTable." SET 
                from_point_id=:from_point_id,
                to_point_id=:to_point_id,
                time=:time,
                cost=:cost
                ";

        $stmt = $this->conn->prepare($insertquery);

        $this->id = htmlspecialchars(strip_tags($this->time));
        $this->name = htmlspecialchars(strip_tags($this->cost));

        $stmt->bindParam(':from_point_id',$this->from_point_id);
        $stmt->bindParam(':to_point_id',$this->to_point_id);
        $stmt->bindParam(':time',$this->time);
        $stmt->bindParam(':cost',$this->cost);

        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:/n'.$stmt->error);
        return false;
    }

    public function update(){

        $this->helper->find = $this->from_point;
        $this->helper->table = $this->secondTable;
        $this->helper->where_field="name";
        $this->helper->find_field="id";
        $this->helper->find();
        $this->from_point_id = $this->helper->found;
        
        $this->helper->find = $this->to_point;
        $this->helper->table = $this->secondTable;
        $this->helper->where_field="name";
        $this->helper->find_field="id";
        $this->helper->find();
        $this->to_point_id = $this->helper->found;

        $findquery = "SELECT id FROM routes WHERE from_point_id=:from_point_id AND to_point_id=:to_point_id";
        $findstmt = $this->conn->prepare($findquery);
        $findstmt->bindParam(':from_point_id',$this->from_point_id);
        $findstmt->bindParam(':to_point_id',$this->to_point_id);
        $findstmt->execute();
        $find= $findstmt->fetch(PDO::FETCH_ASSOC);
        $id = $find['id'];

        $insertquery = "UPDATE ".$this->firstTable." SET
                        time=:time,
                        cost=:cost
                        WHERE
                        id=:id";
                

        $stmt = $this->conn->prepare($insertquery);

        $stmt->bindParam(':id',$id);
        $stmt->bindParam(':time',$this->time);
        $stmt->bindParam(':cost',$this->cost);

        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:/n'.$stmt->error);
        return false;
    }
    public function delete(){
        $this->helper->find = $this->from_point;
        $this->helper->table = $this->secondTable;
        $this->helper->where_field="name";
        $this->helper->find_field="id";
        $this->helper->find();
        $this->from_point_id = $this->helper->found;
        
        $this->helper->find = $this->to_point;
        $this->helper->table = $this->secondTable;
        $this->helper->where_field="name";
        $this->helper->find_field="id";
        $this->helper->find();
        $this->to_point_id = $this->helper->found;

        $findquery = "SELECT id FROM routes WHERE from_point_id=:from_point_id AND to_point_id=:to_point_id";
        $findstmt = $this->conn->prepare($findquery);
        $findstmt->bindParam(':from_point_id',$this->from_point_id);
        $findstmt->bindParam(':to_point_id',$this->to_point_id);
        $findstmt->execute();
        $find= $findstmt->fetch(PDO::FETCH_ASSOC);
        $id = $find['id'];

        $deletequery = "DELETE FROM ".$this->firstTable." WHERE id=:id";
                

        $stmt = $this->conn->prepare($deletequery);

        $stmt->bindParam(':id',$id);
   

        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:/n'.$stmt->error);
        return false;
    }
}