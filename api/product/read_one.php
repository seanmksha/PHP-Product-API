<?php
    // required headers
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../objects/product.php';

    $database = new Database();
    $db = $database->startConnection();

    // prepare product object
    $product = new Product($db);
 
    // set ID property of record to read
    $product->id = isset($_GET['id']) ? $_GET['id'] : die();
 
    // read the details of product to be edited
    $product->readOne();
    /*
    public $id;
    public $name;
    public $description;
    public $price;
    public $category_id;
    public $category_name;
    public $created;
    */
    
    if($product->name!=null){
        $product_arr = [
            "id"=> $product->id,
            "name"=>$product->name,
            "description"=> $product->description,
            "price"=> $product->price,
            "category_id"=>$product->category_id,
            "category_name"=>$product->category_name
        ];
        http_response_code(200);
        echo json_encode($product_arr);
    }
    else{
        http_response_code(404);
        echo json_encode(["message"=>"Product does not exist."]);
    }


?>