<?php
    class Kuitansi{
    // database connection and table name
    private $conn;
    private $table_name = "kuitansi";
    
    // object properties
    public $id_kuitansi;
    public $tgl_kuitansi;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read all products
    function read(){
        $query = "SELECT
                    id_kuitansi, tgl_kuitansi
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id_kuitansi ASC";
                    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // execute query
        $stmt->execute();
        return $stmt;
    }
    
    // read single products by id
    function readOne(){
        // query to read single record
        $query = "SELECT
                    id_kuitansi, tgl_kuitansi
                FROM
                    " . $this->table_name . "
                WHERE
                    id_kuitansi = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
        
        // execute query
        $stmt->execute();
        
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // set values to object properties
        $this->tgl_kuitansi= $row['tgl_kuitansi'];
    }

     // create product
     function create(){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    tgl_kuitansi=:tgl_kuitansi";
                    
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // bind values
        $stmt->bindParam(":tgl_kuitansi", $this->tgl_kuitansi);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    // update the product
    function update(){
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    tgl_kuitansi = :tgl_kuitansi
                WHERE
                    id_kuitansi = :id_kuitansi";
                    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind new values
        $stmt->bindParam(':tgl_kuitansi', $this->tgl_kuitansi);
        $stmt->bindParam(':id_kuitansi', $this->id_kuitansi);
        
        // execute the query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    // delete the product
    function delete(){
        // delete query
        $query = "DELETE FROM "
        . $this->table_name .
        " WHERE id_kuitansi = ?";
        
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // sanitize
        //$this->id=htmlspecialchars(strip_tags($this->id));
        
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
}
?>