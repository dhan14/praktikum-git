<?php
    class Detail_Pesan{
    // database connection and table name
    private $conn;
    private $table_name = "detail_pesan";
    
    // object properties
    public $id_detail_pesan;
    public $jumlah;
    public $harga;
    public $id_pesan;
    public $tgl_pesan;
    public $id_produk;
    public $nama_produk;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read all products
    function read(){
        $query = "SELECT
                detail_pesan.id_detail_pesan,
                pesan.id_pesan,
                pesan.tgl_pesan,
                produk.id_produk,
                produk.nama_produk,
                detail_pesan.jumlah,
                detail_pesan.harga
                FROM " . $this->table_name . "
                INNER JOIN pesan 
                ON pesan.id_pesan = detail_pesan.id_pesan
                INNER JOIN produk 
                ON produk.id_produk = detail_pesan.id_produk
                ORDER BY id_detail_pesan ASC";
                    
                    
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
                detail_pesan.id_detail_pesan,
                pesan.id_pesan,
                pesan.tgl_pesan,
                produk.id_produk,
                produk.nama_produk,
                detail_pesan.jumlah,
                detail_pesan.harga
                FROM " . $this->table_name . "
                INNER JOIN pesan 
                ON pesan.id_pesan = detail_pesan.id_pesan
                INNER JOIN produk 
                ON produk.id_produk = detail_pesan.id_produk
            WHERE
                    id_detail_pesan = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind id of product to be updated
        $stmt->bindParam(1, $this->id_detail_pesan);
        
        // execute query
        $stmt->execute();
        
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // set values to object properties
        $this->id_detail_pesan = $row['id_detail_pesan'];
        $this->id_pesan = $row['id_pesan'];
        $this->id_produk = $row['id_produk'];
        $this->nama_produk = $row['nama_produk'];
        $this->id_produk = $row['id_produk'];
        $this->jumlah = $row['jumlah'];
        $this->harga = $row['harga'];
        $this->tgl_pesan = $row['tgl_pesan'];
    }

     // create product
     function create(){
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    id_produk=:id_produk,
                    id_pesan=:id_pesan,
                    harga=:harga,
                    jumlah=:jumlah";
                    
        // prepare query
        $stmt = $this->conn->prepare($query);
        
        // bind values
        $stmt->bindParam(":id_produk", $this->id_produk);
        $stmt->bindParam(":id_pesan", $this->id_pesan);
        $stmt->bindParam(":harga", $this->harga);
        $stmt->bindParam(":jumlah", $this->jumlah);
        
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
                id_detail_pesan = :id_detail_pesan,
                    jumlah = :jumlah,
                    harga = :harga,
                    id_pesan = :id_pesan,
                    id_produk = :id_produk
                WHERE
                    id_detail_pesan = :id_detail_pesan";
                    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind new values
        $stmt->bindParam(':jumlah', $this->jumlah);
        $stmt->bindParam(':harga', $this->harga);
        $stmt->bindParam(':id_pesan', $this->id_pesan);
        $stmt->bindParam(':id_produk', $this->id_produk);
        $stmt->bindParam(':id_detail_pesan', $this->id_detail_pesan);
        
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
        " WHERE id_detail_pesan = ?";
        
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