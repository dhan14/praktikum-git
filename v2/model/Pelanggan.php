<?php
    class Pelanggan{
    // database connection and table name
    private $conn;
    private $table_name = "pelanggan";
    
    // object properties
    public $id_pelanggan;
    public $nama_pelanggan;
    public $alamat;
    public $telepon;
    public $email;
    public $tgl_lahir;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read all products
    function read(){
        $query = "SELECT
                    id_pelanggan, nama_pelanggan, alamat, telepon, email, tgl_lahir
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id_pelanggan ASC";
                    
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
                    id_pelanggan, nama_pelanggan, alamat, telepon, email, tgl_lahir
                FROM
                    " . $this->table_name . "
                WHERE
                    id_pelanggan = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
        
        // execute query
        $stmt->execute();
        
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // set values to object properties
        $this->nama_pelanggan = $row['nama'];
        $this->alamat = $row['alamat'];
        $this->telepon = $row['telepon'];
        $this->email = $row['email'];
        $this->tgl_lahir = $row['tgl_lahir'];
    }

     // create product
     function create(){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nama_pelanggan=:nama_pelanggan,
                    alamat=:alamat,
                    telepon=:telepon,
                    email=:email,
                    tgl_lahir=:tgl_lahir";
                    
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // bind values
        $stmt->bindParam(":nama_pelanggan", $this->nama_pelanggan);
        $stmt->bindParam(":alamat", $this->alamat);
        $stmt->bindParam(":telepon", $this->telepon);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":tgl_lahir", $this->tgl_lahir);
        
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
                    nama_pelanggan = :nama_pelanggan,
                    alamat = :alamat,
                    telepon = :telepon,
                    email = :email,
                    tgl_lahir = :tgl_lahir

                WHERE
                    id_pelanggan = :id_pelanggan";
                    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind new values
        $stmt->bindParam(':nama_pelanggan', $this->nama_pelanggan);
        $stmt->bindParam(':alamat', $this->alamat);
        $stmt->bindParam(':telepon', $this->telepon);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':tgl_lahir', $this->tgl_lahir);
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        
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
        " WHERE id_pelanggan = ?";
        
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