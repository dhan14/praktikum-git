<?php
    class Produk{
    // database connection and table name
    private $conn;
    private $table_name = "produk";
    
    // object properties
    public $id_produk;
    public $nama_produk;
    public $satuan;
    public $harga;
    public $stock;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read all products
    function read(){
        $query = "SELECT
                    id_produk, nama_produk, satuan, harga, stock
                FROM
                    " . $this->table_name . "
                ORDER BY
                    id_produk ASC";
                    
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
                    id_produk, nama_produk, satuan, harga, stock
                FROM
                    " . $this->table_name . "
                WHERE
                    id_produk = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id);
        
        // execute query
        $stmt->execute();
        
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // set values to object properties
        $this->nama_produk = $row['nama_produk'];
        $this->satuan = $row['satuan'];
        $this->harga = $row['harga'];
        $this->stock = $row['stock'];
    }

     // create product
     function create(){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    nama_produk=:nama_produk,
                    satuan=:satuan,
                    harga=:harga,
                    stock=:stock";
                    
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // bind values
        $stmt->bindParam(":nama_produk", $this->nama_produk);
        $stmt->bindParam(":satuan", $this->satuan);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":stock", $this->stock);

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
                    nama_produk = :nama_produk,
                    satuan = :satuan,
                    harga = :harga,
                    stock = :stock
                WHERE
                    id_produk = :id_prpduk";
                    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind new values
        $stmt->bindParam(':nama_produk', $this->nama_produk);
        $stmt->bindParam(':satuan', $this->satuan);
        $stmt->bindParam(':harga', $this->harga);
        $stmt->bindParam(':satuan', $this->satuan);
        $stmt->bindParam(':stock', $this->stock);
        $stmt->bindParam(':id_prouk', $this->id_produk);
        
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
        " WHERE id_produk = ?";
        
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