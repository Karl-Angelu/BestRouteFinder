<?php 

class User{
    private $conn;
    private $table="users";

    // Post fields
    public $id;
    public $name;
    public $password;
    public $role;
    public $created_at;
    public $updated_at;


    public function __construct($db){
    $this->conn = $db;
    }

    public function read(){
        $query = "SELECT * FROM ".$this->table;

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt;
        
    }

    public function read_single(){
        $query = "SELECT * FROM ".$this->table." WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->id = $row['id'];
        $this->name = $row['name'];
        $this->role = $row['role'];
    }
    public function create(){

        $query = "INSERT INTO ".$this->table." SET 
                name=:name,
                password=:password,
                role = :role";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));

        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':password',$this->password);
        $stmt->bindParam(':role',$this->role);
        
        
        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:/n'.$stmt->error);
        return false;
    }
    public function update(){
        $query = "UPDATE ".$this->table." SET
                name = :name,
                password = :password,
                role = :role
                WHERE id = :id
                ";
      
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->role = htmlspecialchars(strip_tags($this->role));

        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':password',$this->password);
        $stmt->bindParam(':role',$this->role);
        $stmt->bindParam(':id',$this->id);

        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:/n'.$stmt->error);
        return false;

    }
    public function delete(){
        $query = "DELETE FROM ".$this->table." WHERE id=:id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id',$this->id);
        
        if($stmt->execute()){
            return true;
        }
        printf('Error: %s:\n'.$stmt->error);
        return false;

    }
    public function checkuser(){
        $query = "SELECT * FROM ".$this->table.
        " WHERE 
        name=:name 
        AND 
        password=:password
        LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name',$this->name);
        $stmt->bindParam(':password',$this->password);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $num = $stmt->rowCount();

        if($num){
            return $row['role'];
        }else{
            return false;
        }
    }
}