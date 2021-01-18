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
$data = json_decode(file_get_contents("http://produkty-uslugi.herokuapp.com/products"));

// sprawdzanie czy dane nie sa puste
foreach($data as $key => $value) {

if (!empty($value->nazwa) &&
    !empty($value->cena_netto) &&
    is_numeric($value->cena_netto) &&
    preg_match("/^[a-zA-Z]+$/", $value->jednostka_miary) &&
    !empty($value->jednostka_miary) &&
    !empty($value->stawka) &&
    is_numeric($value->stawka)) {

    // ustawienie wartosci towaru
    $cargo->nazwa           = $value->nazwa;
    $cargo->cena            = $value->cena_netto;
    $cargo->jednostka_miary = $value->jednostka_miary;
    $cargo->stawka_vat      = $value->stawka;

    // utworz towar
    if ($cargo->create()) {

        // ustawienie kodu odpowiedzi na - 201 created
        http_response_code(201);

        // wyswietlenie wiadomosci ze udalo sie stworzyc towar
        // echo json_encode(array(
        //     "Sukces" => "Towar został utworzony."
        // ));
    }

    // jezeli nie udalo sie stworzyc
    else {

        // ustawienie kodu odpowiedzi n - 503 service unavailable
        http_response_code(503);

        // wyswietlenie wiadomosci ze nie udalo sie stworzyć towaru
        // echo json_encode(array(
        //     "Błąd" => "Nie udało się stworzyć towaru."
        // ));
    }


}
// jezeli dane sa puste
else {

    // ustawienie kodu odpowiedzi na - 400 bad request
    http_response_code(400);

    // wyswietlenie wiadomosci ze dane sa nie kompletne
    echo json_encode(array(
        "Błąd" => "Nie udalo sie stworzyc towaru, dane sa nie kompletne lub mają nie poprawny format."
    ));
}
}
?>
