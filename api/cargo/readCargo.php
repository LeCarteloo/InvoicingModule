<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection
// include database and object files

include_once 'D:\Xampp\htdocs\Project\config\database.php';
include_once '../objects/cargo.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$cargo = new Cargo($db);

if(isset($_GET['input'])){
  $stmt = $cargo->searchCargo($_GET['input']);
}
else{
  $stmt = $cargo->read();
}
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $products_arr=array();
    $products_arr["Towary"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $product_item=array(
            "id_towar" => $id_towar,
            "nazwa" => $nazwa,
            "cena" => $cena,
            "jednostka_miary" => $jednostka_miary,
            "stawka_vat" => $stawka_vat
        );

        array_push($products_arr["Towary"], $product_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($products_arr);
}
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}

?>
