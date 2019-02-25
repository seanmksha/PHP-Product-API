<?php
   header("Access-Control-Allow-Origin: *");
   header("Content-Type: application/json; charset=UTF-8");
   header("Access-Control-Allow-Methods: POST");
   header("Access-Control-Max-Age: 3600");
   header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
   
   include_once('../config/database.php');
   include_once('../objects/product.php');
   
   $database = new Database();
   $db = $database->startConnection();
   $product = new Product($db);
   $data = json_decode(file_get_contents("php://input"));
   $product->id = $data->id;
   $product->name = $data->name;
   $product->price = $data->price;
   $product->description= $data->description;
    if($product->update()){
        http_response_code(200);
        echo json_encode(["message"=>"Product was updated."]);
    }
    else{
        http_response_code(400);
        echo json_encode(["message"=>"Unable to create product. Data is incomplete."]);
    }
?>