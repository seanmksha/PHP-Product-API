<?php
class Product{
    private $conn;
    private $table_name = "products";

    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    public function __construct($db){
        $this->conn=$db;
    }
    function delete(){
        $query = "DELETE FROM $this->table_name WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $this->id=$this->sanitize($this->id);
        $stmt->bindParam(1,$this->id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    function read(){
        $query = "SELECT c.name as category_name, p.id,p.name,p.description,p.price,p.category_id,p.created FROM
        $this->table_name p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
    function count(){
        $query = "Select Count(*) as total_rows from $this->table_name";
        $stmt= $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total_rows'];
    }
    public function readPaging($from_record_num, $records_per_page){
        $query = "SELECT
                c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories c
                        ON p.category_id = c.id
            ORDER BY p.created DESC
            LIMIT ? OFFSET ?";
            // prepare query statement
            $stmt = $this->conn->prepare( $query );
 
        // bind variable values
        $stmt->bindParam(1, $records_per_page, PDO::PARAM_INT);
        $stmt->bindParam(2, $from_record_num, PDO::PARAM_INT);
        $stmt->execute();

    return $stmt;


    }
    function search($keywords){
        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created FROM
        $this->table_name p LEFT JOIN categories c ON p.category_id = c.id
        WHERE
        p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?
        ORDER BY
        p.created DESC";
        $stmt=$this->conn->prepare($query);
        $keywords=sanitize($keywords);
        $stmt->bindParam(1,$keywords);
        $stmt->bindParam(2,$keywords);
        $stmt->bindParam(3,$keywords);
        $stmt->execute();
        return $stmt;
    }
    function readOne(){
        $query = "SELECT c.name as category_name, p.id, p.name, p.description, p.price, p.category_id, p.created
        FROM $this->table_name p
            LEFT JOIN
                categories c
                    ON p.category_id = c.id
            WHERE
                p.id=?
            LIMIT
                0,1";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1,$this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->description = $row['description'];
        $this->category_id = $row['category_id'];
        $this->category_name = $row['category_name'];
    }
    function update(){
        $query="UPDATE $this->table_name p
                SET p.name=:name, p.description=:description, p.price =:price,category_id=:category_id
                WHERE id = :id";
                $stmt = $this->conn->prepare($query);
                $this->name=$this->sanitize($this->name);
                $this->price= $this->sanitize($this->price);
                $this->description = $this->sanitize($this->description);
                $this->category_id = $this->sanitize($this->category_id);
                $this->id = $this->sanitize($this->id);
                $stmt->bindParam(":name",$this->name);
                $stmt->bindParam(":price",$this->price);
                $stmt->bindParam(":description",$this->description);
                $stmt->bindParam(":category_id",$this->category_id);
                $stmt->bindParam(":id",$this->id);
                if($stmt->execute()){
                    return true;
                }
                return false;
    }
    function sanitize($str){
        return htmlspecialchars(strip_tags($str));
    }
    
    
    function create(){
        $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
 
                $this->name=$this->sanitize($this->name);
                $this->price= $this->sanitize($this->price);
                $this->description = $this->sanitize($this->description);
                $this->category_id = $this->sanitize($this->category_id);
                $this->created = $this->sanitize($this->created);
        $stmt->bindParam(":name",$this->name);
        $stmt->bindParam(":price",$this->price);
        $stmt->bindParam(":description",$this->description);
        $stmt->bindParam(":category_id",$this->category_id);
        $stmt->bindParam(":created",$this->created);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

}
?>