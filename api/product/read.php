<?php
    header("Access-Control-Allow_Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/product.php';

    $database = new Database();
    $db = $database->startConnection();

    $product = new Product($db);

    $stmt = $product->read();
    $numRows = $stmt->rowCount();
    if($numRows>0){
        $products_arr=[];
        $products_arr["records"]=[];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $product_item = [
                "id"=>$id,
                "name"=>$name,
                "descritpion"=> html_entity_decode($description),
                "price"=> $price,
                "category_id"=>$category_id,
                "category_name"=>$category_name
            ];
            array_push($products_arr["records"],$product_item);
        }
        http_response_code(200);

        echo json_encode($products_arr);


    }
?>