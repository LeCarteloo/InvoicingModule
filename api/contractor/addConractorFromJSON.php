<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// dodanie polaczenia z database.php i dodanie obiektu contractor.php
include_once '../../config/database.php';
include_once '../objects/contractor.php';

$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu contractor
$contractor = new Contractor($db);

// uzyskaj dane z pliku JSON
$data = json_decode(file_get_contents("php://input"));

$check = array("/",","," ",".","*","-","_");

$NIP = str_replace($check,'',$data->NIP);

// sprawdzanie czy dane nie sa puste
if (!empty($data->nazwa_nabywcy) &&
    !empty($data->adres) &&
    !empty($data->NIP) &&
    $contractor->isValidNIP($NIP)) {

    if(!empty($data->email_nabywcy) && !filter_var($data->email_nabywcy,FILTER_VALIDATE_EMAIL)){
      goto test;
    }
    else{
      $contractor->email_nabywcy = $data->email_nabywcy;
    }
    // ustawienie wartosci kontrahenta
    $contractor->nazwa_nabywcy = $data->nazwa_nabywcy;
    $contractor->adres         = $data->adres;
    $contractor->NIP           = $NIP;
    // utworz kontrahenta
    if ($contractor->create()) {

        // ustawienie kodu odpowiedzi na - 201 created
        http_response_code(201);

        // wyswietlenie wiadomosci ze udalo sie stworzyc kontrahenta
        echo json_encode(array(
            "Sukces" => "Kontrahent został utworzony."
        ));
    }

    // jezeli nie udalo sie stworzyc
    else {

        // ustawienie kodu odpowiedzi n - 503 service unavailable
        http_response_code(503);

        // wyswietlenie wiadomosci ze nie udalo sie stworzyć kontrahenta
        echo json_encode(array(
            "Błąd" => "Nie udało się stworzyć kontrahenta."
        ));
    }


}
// jezeli dane sa puste
else {
  test:
    // ustawienie kodu odpowiedzi na - 400 bad request
    http_response_code(400);

    // wyswietlenie wiadomosci ze dane sa nie kompletne
    echo json_encode(array(
        "Błąd" => "Nie udalo sie stworzyc kontrahenta, dane sa nie kompletne lub mają niepoprawny format."
    ));
}
?>
