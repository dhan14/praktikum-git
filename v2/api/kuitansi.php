<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    // get database connection
    include_once '../../v2/config/database.php';
    // instantiate product model
    include_once '../../v2/model/kuitansi.php';
    
    //Connection to databaser
    $database = new Database();
    $db = $database->getConnection();
    
    //create objek produk
    $kuitansi = new Kuitansi($db);
    //get request method from client
    $request = $_SERVER['REQUEST_METHOD'];
    
    //check request method clien
    switch ($request)
    {
        case 'GET' :
            //code if the client request method GET
            if(!isset($_GET['id'])){
                $stmt = $kuitansi->read();
                $num = $stmt->rowCount();
                
                // check if more than 0 record found
                if($num>0){
                    
                    // products array
                    $kuitansis_arr=array();
                    $kuitansis_arr["records"]=array();
                    
                    // retrieve our table contents
                    // fetch() is faster than fetchAll()
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        // extract row
                        // this will make $row['name'] to
                        // just $name only
                        extract($row);
                        
                        $kuitansi_item=array(
                            "id_kuitansi" => $id_kuitansi,
                            "tgl_kuitansi" => $tgl_kuitansi
                        );
                        
                        array_push($kuitansis_arr["records"], $kuitansi_item);
                    }
                    
                    // set response code - 200 OK
                    http_response_code(200);
                    
                    // show products data in json format
                    echo json_encode($kuitansis_arr);
                }
                else{
                    // no products found will be here
                    // set response code - 404 Not found
                    http_response_code(404);
                    
                    // tell the user no products found
                    echo json_encode(
                        array("message" => "No kuitansi found.")
                    );
                }
            }
            elseif($_GET['id'] == NULL){
                echo json_encode(array("message" => "Parameter Id id tidak boleh kosong"));
            }
            else{
                
                // set ID property of record to read
                $kuitansi->id =$_GET['id'];
                
                // read the details of product to be edited
                $kuitansi->readOne();
                
                if($kuitansi->id!=null){
                    // create array
                    $kuitansi_item=array(
                        "id_kuitansi" => $kuitansi->id,
                        "tgl_kuitansi" => $kuitansi->tgl_kuitansi
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
                    echo json_encode(array("message" => "kuitansi does not exist."));
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
                    isset($_POST['tgl_kuitansi'])
                )
            {
            //menerima kiriman data melalui method request POST
                $kuitansi->tgl_kuitansi = $_POST['tgl__kuitansi'];
                
                // create the product
                if($kuitansi->create()){
                    
                    // set response code - 201 created
                    http_response_code(201);
                    //echo json_encode(array("kode_status" => "201"));
                    
                    // tell the user
                    echo json_encode(array("kuitansi_succes" => "Kuitansi was created."));
                }
                
                // if unable to create the product, tell the user
                else{
                    
                    // set response code - 503 service unavailable
                    http_response_code(503);
                    
                    // tell the user
                    //echo json_encode(array("message" => "Unable to create product."));
                    
                    $result=array(
                        "status_kode" => 503,
                        "status_massage" => "Unable to create kuitansi"
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
                    "status_massage" => "Unable to create kuitansi"
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
                $kuitansi->id = $data->id;
                $kuitansi->tgl_kuitansi = $data->tgl_kuitansi;
                
                if($kuitansi->update()){
                    
                    // set response code - 200 ok
                    http_response_code(200);
                    
                    // tell the user
                    echo json_encode(array("message" => "Kuitansi was updated."));
                }
                
                // if unable to update the product, tell the user
                else{
                    
                    // set response code - 503 service unavailable
                    http_response_code(503);
                    
                    $result=array(
                        "status_kode" => 503,
                        "status_massage" => "Bad Request, Unable to update kuitansi"
                    );
                    echo json_encode($result);
                    
                    // tell the user
                    echo json_encode(array("message" => "Unable to update kuitansi."));
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
                $kuitansi->id =$_GET['id'];
                
                // delete the product
                if($kuitansi->delete()){
                    
                    // set response code - 200 ok
                    http_response_code(200);

                    // tell the user
                    echo json_encode(array("message" => "Kuitansi was deleted."));
                
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