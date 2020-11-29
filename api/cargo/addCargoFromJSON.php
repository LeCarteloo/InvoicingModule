<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// dodanie polaczenia z database.php i dodanie obiektu cargo.php
include_once '../../config/database.php';
include_once '../objects/cargo.php';

$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu cargo
$cargo = new Cargo($db);

// uzyskaj dane z pliku JSON
$data = json_decode(file_get_contents("php://input"));

// sprawdzanie czy dane nie sa puste
if (!empty($data->nazwa) &&
    !empty($data->cena) &&
    !empty($data->jednostka_miary) &&
    !empty($data->stawka_vat)) {

    // ustawienie wartosci towaru
    $cargo->nazwa           = $data->nazwa;
    $cargo->cena            = $data->cena;
    $cargo->jednostka_miary = $data->jednostka_miary;
    $cargo->stawka_vat      = $data->stawka_vat;

    // utworz towar
    if ($cargo->create()) {

        // ustawienie kodu odpowiedzi na - 201 created
        http_response_code(201);

        // wyswietlenie wiadomosci ze udalo sie stworzyc towar
        echo json_encode(array(
            "Sukces" => "Towar został utworzony."
        ));
    }

    // jezeli nie udalo sie stworzyc
    else {

        // ustawienie kodu odpowiedzi n - 503 service unavailable
        http_response_code(503);

        // wyswietlenie wiadomosci ze nie udalo sie stworzyć towaru
        echo json_encode(array(
            "Błąd" => "Nie udało się stworzyć towaru."
        ));
    }


}
// jezeli dane sa puste
else {

    // ustawienie kodu odpowiedzi na - 400 bad request
    http_response_code(400);

    // wyswietlenie wiadomosci ze dane sa nie kompletne
    echo json_encode(array(
        "Błąd" => "Nie udalo sie stworzyc towaru, dane sa nie kompletne."
    ));
}
?>
