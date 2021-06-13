<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // get database connection
    include_once '../../v2/config/Database.php';
    // instantiate product model
    include_once '../../v2/model/Detail_Pesan.php';
    
    //Connection to databaser
    $database = new Database();
    $db = $database->getConnection();
    
    //create objek produk
    $detail_pesan = new Detail_Pesan($db);
    //get request method from client
    $request = $_SERVER['REQUEST_METHOD'];
    
    //check request method clien
    switch ($request)
    {
        case 'GET' :
            //code if the client request method GET
            if(!isset($_GET['id_detail_pesan'])){
                $stmt = $detail_pesan->read();
                $num = $stmt->rowCount();
                
                // check if more than 0 record found
                if($num>0){
                    
                    // products array
                    $detail_pesans_arr=array();
                    $detail_pesans_arr["records"]=array();
                    
                    // retrieve our table contents
                    // fetch() is faster than fetchAll()
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        // extract row
                        // this will make $row['name'] to
                        // just $name only
                        extract($row);
                        
                        $detail_pesan_item=array(
                            "id_detail_pesan" => $id_detail_pesan,
                            "id_pesan" => $id_pesan,
                            "id_produk" => $id_produk,
                            "jumlah" => $jumlah,
                            "harga" => $harga,
                            "tgl_pesan" => $tgl_pesan,
                            "nama_produk" => $nama_produk

                        );
                        
                        array_push($detail_pesans_arr["records"], $detail_pesan_item);
                    }
                    
                    // set response code - 200 OK
                    http_response_code(200);
                    
                    // show products data in json format
                    echo json_encode($detail_pesans_arr);
                }
                else{
                    // no products found will be here
                    // set response code - 404 Not found
                    http_response_code(404);
                    
                    // tell the user no products found
                    echo json_encode(
                        array("message" => "No detail_pesan found.")
                    );
                }
            }
            elseif($_GET['id_detail_pesan'] == NULL){
                echo json_encode(array("message" => "Parameter Id id tidak boleh kosong"));
            }
            else{
                
                // set ID property of record to read
                $detail_pesan->id_detail_pesan =$_GET['id_detail_pesan'];
                
                // read the details of product to be edited
                $detail_pesan->readOne();
                
                if($detail_pesan->id_detail_pesan!=null){
                    // create array
                    $produk_item=array(
                        "id_detail_pesan" => $detail_pesan->id_detail_pesan,
                        "jumlah" => $detail_pesan->jumlah,
                        "harga" => $detail_pesan->harga,
                        "id_pesan" => $detail_pesan->id_pesan,
                        "tgl_pesan" => $detail_pesan->tgl_pesan,
                        "id_produk" => $detail_pesan->id_produk,
                        "nama_produk" => $detail_pesan->nama_produk
                    );
                
                    // set response code - 200 OK
                    http_response_code(200);
                    
                    // make it json format
                    echo json_encode($produk_item);
                }
                else{
                    // set response code - 404 Not found
                    http_response_code(404);
                    
                    // tell the user product does not exist
                    echo json_encode(array("message" => "detail_pesan does not exist."));
                }
            }
        break;

        case 'POST' :
            //code if the client request method is POST
            //melakukan pengecekan apakah parameter yang dikirmkan melalui
            //methode qeruest post melalui form inputan
            //body -> x-www-form-urlencoded,
            //bukan melalui raw data
                if(
                    isset($_POST['jumlah'])&&
                    isset($_POST['harga'])&&
                    isset($_POST['id_pesan'])&&
                    isset($_POST['id_produk'])

                )
            {
            //menerima kiriman data melalui method request POST
                $detail_pesan->jumlah = $_POST['jumlah'];
                $detail_pesan->harga = $_POST['harga'];
                $detail_pesan->id_produk = $_POST['id_produk'];
                $detail_pesan->id_pesan = $_POST['id_pesan'];
                
                // create the product
                if($detail_pesan->create()){
                    
                    // set response code - 201 created
                    http_response_code(201);
                    //echo json_encode(array("kode_status" => "201"));
                    
                    // tell the user
                    echo json_encode(array("pesan_succes" => "detail_pesan was created."));
                }
                
                // if unable to create the product, tell the user
                else{
                    
                    // set response code - 503 service unavailable
                    http_response_code(503);
                    
                    // tell the user
                    //echo json_encode(array("message" => "Unable to create product."));
                    
                    $result=array(
                        "status_kode" => 503,
                        "status_massage" => "Unable to create detail_pesan"
                    );
                    echo json_encode($result);
                }
            }
            // tell the user data is incomplete
            else{
                
                // set response code - 400 bad request
                http_response_code(400);
                
                $result=array(
                    "status_kode" => 400,
                    "status_massage" => "Unable to create detail_pesan"
                );
                echo json_encode($result);
                
                // tell the user
                //echo json_encode(array("message" => "Unable to create product. Data is incomplete.".$_POST['nama']));
            }
        break;

        case 'PUT' :
            //code if the client request method is PUT
            $data = json_decode(file_get_contents("php://input"));
            $id_detail_pesan = $data->id_detail_pesan;
            //echo 'parameter post'.$_POST['id'];
            //echo 'parameter post'.$_PUT['id'];
            if($id_detail_pesan==""|| $id_detail_pesan==null){
                echo json_encode(array("message" => "Parameter Id tidak boleh kosong"));
            }
            else{
                $detail_pesan->jumlah = $data->jumlah;
                $detail_pesan->harga = $data->harga;
                $detail_pesan->id_pesan = $data->id_pesan;
                $detail_pesan->id_detail_pesan = $data->id_detail_pesan;
                $detail_pesan->id_produk = $data->id_produk;
                
                if($detail_pesan->update()){
                    
                    // set response code - 200 ok
                    http_response_code(200);
                    
                    // tell the user
                    echo json_encode(array("message" => "Detail_Pesan was updated."));
                }
                
                // if unable to update the product, tell the user
                else{
                    
                    // set response code - 503 service unavailable
                    http_response_code(503);
                    
                    $result=array(
                        "status_kode" => 503,
                        "status_massage" => "Bad Request, Unable to update detail_pesan"
                    );
                    echo json_encode($result);
                    
                    // tell the user
                    echo json_encode(array("message" => "Unable to update detail_pesan."));
                }
            }
        break;

        case 'DELETE' :
            //code if the client request method is DELETE
            if(!isset($_GET['id_detail_pesan'])){
                echo json_encode(array("message" => "Parameter Id id tidak ada"));
            
            }
            elseif($_GET['id_detail_pesan'] == NULL){
                echo json_encode(array("message" => "Parameter Id id tidak boleh kosong"));
            }
            else{
                
                // set product id to be deleted
                $detail_pesan->id =$_GET['id_detail_pesan'];
                
                // delete the product
                if($detail_pesan->delete()){
                    
                    // set response code - 200 ok
                    http_response_code(200);

                    // tell the user
                    echo json_encode(array("message" => "detail_pesan was deleted."));
                
                }
                
                // if unable to delete the product
                else{
                    
                    // set response code - 503 service unavailable
                    http_response_code(503);
                    
                    $result=array(
                        "status_kode" => 503,
                        "status_massage" => "Bad Request, Unable to delete product"
                    );
                    echo json_encode($result);
                    
                    // tell the user
                    echo json_encode(array("message" => "Unable to delete product."));
                }
            }
        break;

        default :
        //code if the client request is not GET, POST, PUT, DELETE
        http_response_code(404);
        echo "Request tidak diizinkan";
        
    }
?>