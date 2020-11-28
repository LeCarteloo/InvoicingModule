<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../../config/database.php';

// instantiate product object
include_once '../objects/invoice.php';
include_once '../objects/invoiceCargo.php';

$database = new Database();
$db = $database->getConnection();

$product = new Invoice($db);

$invoiceCargo = new invoiceCargo($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->numer_faktury) &&
    !empty($data->id_nabywca) &&
    !empty($data->id_status) &&
    !empty($data->data_wystawienia)&&
    !empty($data->data_sprzedazy)&&
    !empty($data->towary)
){

    // set product property values
    $product->numer_faktury = $data->numer_faktury;
    $product->id_nabywca = $data->id_nabywca;
    $product->id_status = $data->id_status;
    $product->data_wystawienia = $data->data_wystawienia;
    $product->data_sprzedazy = $data->data_sprzedazy;

    // $product->created = date('Y-m-d H:i:s');

    // create the product
    if($product->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }

    foreach($data->towary as $towar) {

        $invoiceCargo->ilosc = $towar->ilosc;
        $invoiceCargo->id_towar = $towar->id_towar;

        // create the product
        if($invoiceCargo->createInvoiceCargo()){

            // set response code - 201 created
            http_response_code(201);

            // tell the user
            echo json_encode(array("message" => "Product was created.1"));
        }

        // if unable to create the product, tell the user
        else{

            // set response code - 503 service unavailable
            http_response_code(503);

            // tell the user
            echo json_encode(array("message" => "Unable to create product.1"));
        }
    }

}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>
