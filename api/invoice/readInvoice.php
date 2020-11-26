<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection
// include database and object files

include_once 'D:\Xampp\htdocs\Project\config\database.php';
include_once '../objects/invoice.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$invoice = new Invoice($db);

// query products
$stmt = $invoice->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $products_arr=array();
    $products_arr["Faktury"]=array();

    $products_TEST=array();
    $products_TEST["Towary"]=array();


    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    $TEST;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $products_TEST = array(
          "nazwa" => $nazwa,
          "cena" => $cena,
          "jednostka_miary" => $jednostka_miary,
          "stawka_vat" => $stawka_vat,
          "status_faktury" => $status_faktury,
          "ilosc" => $ilość
        );
        $product_item=array(
            "numer_faktury" => $numer_faktury,
            "data_wystawienia" => $data_wystawienia,
            "data_sprzedazy" => $data_sprzedazy,
            "nazwa_nabywcy" => $nazwa_nabywcy,
            "adres" => $adres,
            "NIP" => $NIP,
            "email_nabywcy" => $email_nabywcy,
            "produkt" => $products_TEST
        );


        array_push($products_arr["Faktury"], $product_item);
    }
    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($products_arr["Faktury"]);

}
else{

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No contractors found.")
    );
}

?>
