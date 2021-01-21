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
$data = @json_decode(@file_get_contents("http://tslezajsk.pl/Kontrahenci/api/contractor/readendpoint.php?nip=". $_GET['NIP']));

if($data){

foreach ($data->KontrahenciEndPoint as $key => $value) {

$check = array("/",","," ",".","*","-","_");

$NIP = str_replace($check,'',$value->nip);

// sprawdzanie czy dane nie sa puste
$adres = $value->ulica." ".$value->numer_budynku;

if (!empty($value->nazwa_firmy) &&
    !empty($adres) &&
    !empty($NIP) &&
    $contractor->isValidNIP($NIP)) {

    if(!empty($value->email) && !filter_var($value->email,FILTER_VALIDATE_EMAIL)){
      goto error;
    }
    else{
      $contractor->email_nabywcy = $value->email;
    }
    // ustawienie wartosci kontrahenta
    $contractor->nazwa_nabywcy = $value->nazwa_firmy;
    $contractor->adres         = $adres;
    $contractor->NIP           = $NIP;
    // utworz kontrahenta
    if ($contractor->create()) {

        // ustawienie kodu odpowiedzi na - 201 created
        http_response_code(201);

        // wyswietlenie wiadomosci ze udalo sie stworzyc kontrahenta
        // echo json_encode(array(
        //     "Sukces" => "Kontrahent został utworzony."
        // ));
    }

    // jezeli nie udalo sie stworzyc
    else {

        // ustawienie kodu odpowiedzi n - 503 service unavailable
        http_response_code(503);

        // wyswietlenie wiadomosci ze nie udalo sie stworzyć kontrahenta
        // echo json_encode(array(
        //     "Błąd" => "Nie udało się stworzyć kontrahenta."
        // ));
    }


}
// jezeli dane sa puste
else {
  error:
    // ustawienie kodu odpowiedzi na - 400 bad request
    http_response_code(400);

    // wyswietlenie wiadomosci ze dane sa nie kompletne
    echo json_encode(array(
        "Błąd" => "Nie udalo sie stworzyc kontrahenta, dane sa nie kompletne lub mają niepoprawny format."
    ));
}
}
}
?>
