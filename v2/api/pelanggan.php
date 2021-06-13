<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // get database connection
    include_once '../../v2/config/database.php';
    // instantiate product model
    include_once '../../v2/model/pelanggan.php';
    
    //Connection to databaser
    $database = new Database();
    $db = $database->getConnection();
    
    //create objek produk
    $pelanggan = new Pelanggan($db);
    //get request method from client
    $request = $_SERVER['REQUEST_METHOD'];
    
    //check request method clien
    switch ($request)
    {
        case 'GET' :
            //code if the client request method GET
            if(!isset($_GET['id_pelanggan'])){
                $stmt = $pelanggan->read();
                $num = $stmt->rowCount();
                
                // check if more than 0 record found
                if($num>0){
                    
                    // products array
                    $pelanggans_arr=array();
                    $pelanggans_arr["records"]=array();
                    
                    // retrieve our table contents
                    // fetch() is faster than fetchAll()
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        // extract row
                        // this will make $row['name'] to
                        // just $name only
                        extract($row);
                        
                        $pelanggan_item=array(
                            "id_pelanggan" => $id_pelanggan,
                            "nama_pelanggan" => $nama_pelanggan,
                            "alamat" => $alamat,
                            "telepon" => $telepon,
                            "tgl_lahir" => $tgl_lahir
  
                        );
                        
                        array_push($pelanggans_arr["records"], $pelanggan_item);
                    }
                    
                    // set response code - 200 OK
                    http_response_code(200);
                    
                    // show products data in json format
                    echo json_encode($pelanggans_arr);
                }
                else{
                    // no products found will be here
                    // set response code - 404 Not found
                    http_response_code(404);
                    
                    // tell the user no products found
                    echo json_encode(
                        array("message" => "No pelanggan found.")
                    );
                }
            }
            elseif($_GET['id'] == NULL){
                echo json_encode(array("message" => "Parameter Id id tidak boleh kosong"));
            }
            else{
                
                // set ID property of record to read
                $pelanggan->id =$_GET['id'];
                
                // read the details of product to be edited
                $pelanggan->readOne();
                
                if($pelanggan->id!=null){
                    // create array
                    $produk_item=array(
                        "id_pelanggan" => $pelanggan->id,
                        "nama_pelanggan" => $pelanggan->nama_pelanggan,
                        "alamat" => $pelanggan->alamat,
                        "email" => $pelanggan->email,
                        "tgl_lahir" => $pelanggan->tgl_lahir
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
                    echo json_encode(array("message" => "pelanggan does not exist."));
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
                    isset($_POST['nama_pelanggan'])&&
                    isset($_POST['alamat'])&&
                    isset($_POST['telepon'])&&
                    isset($_POST['email'])&&
                    isset($_POST['tgl_lahir'])
                )
            {
            //menerima kiriman data melalui method request POST
                $pelanggan->nama_pelanggan = $_POST['nama_pelanggan'];
                $pelanggan->alamat = $_POST['alamat'];
                $pelanggan->telepon = $_POST['telepon'];
                $pelanggan->email = $_POST['email'];
                $pelanggan->tgl_lahir = $_POST['tgl_lahir'];

                // create the product
                if($pelanggan->create()){
                    
                    // set response code - 201 created
                    http_response_code(201);
                    //echo json_encode(array("kode_status" => "201"));
                    
                    // tell the user
                    echo json_encode(array("pesan_succes" => "pelanggan was created."));
                }
                
                // if unable to create the product, tell the user
                else{
                    
                    // set response code - 503 service unavailable
                    http_response_code(503);
                    
                    // tell the user
                    //echo json_encode(array("message" => "Unable to create product."));
                    
                    $result=array(
                        "status_kode" => 503,
                        "status_massage" => "Unable to create pelanggan"
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
                    "status_massage" => "Unable to create pelanggan"
                );
                echo json_encode($result);
                
                // tell the user
                //echo json_encode(array("message" => "Unable to create product. Data is incomplete.".$_POST['nama']));
            }
        break;

        case 'PUT' :
            //code if the client request method is PUT
            $data = json_decode(file_get_contents("php://input"));
            $id = $data->id;
            //echo 'parameter post'.$_POST['id'];
            //echo 'parameter post'.$_PUT['id'];
            if($id==""|| $id==null){
                echo json_encode(array("message" => "Parameter Id tidak boleh kosong"));
            }
            else{
                $pelanggan->id = $data->id;
                $pelanggan->nama_pelanggan = $data->nama_pelanggan;
                $pelanggan->alamat = $data->alamat;
                $pelanggan->telepon = $data->telepon;
                $pelanggan->email = $data->email;
                $pelanggan->tgl_lahir = $data->tgl_lahir;

                if($pelanggan->update()){
                    
                    // set response code - 200 ok
                    http_response_code(200);
                    
                    // tell the user
                    echo json_encode(array("message" => "Pelanggan was updated."));
                }
                
                // if unable to update the product, tell the user
                else{
                    
                    // set response code - 503 service unavailable
                    http_response_code(503);
                    
                    $result=array(
                        "status_kode" => 503,
                        "status_massage" => "Bad Request, Unable to update pelanggan"
                    );
                    echo json_encode($result);
                    
                    // tell the user
                    echo json_encode(array("message" => "Unable to update pelanggan."));
                }
            }
        break;

        case 'DELETE' :
            //code if the client request method is DELETE
            if(!isset($_GET['id'])){
                echo json_encode(array("message" => "Parameter Id id tidak ada"));
            
            }
            elseif($_GET['id'] == NULL){
                echo json_encode(array("message" => "Parameter Id id tidak boleh kosong"));
            }
            else{
                
                // set product id to be deleted
                $pelanggan->id =$_GET['id'];
                
                // delete the product
                if($pelanggan->delete()){
                    
                    // set response code - 200 ok
                    http_response_code(200);

                    // tell the user
                    echo json_encode(array("message" => "pelanggan was deleted."));
                
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