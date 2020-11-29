<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// dodanie polaczenia z database.php i dodanie obiektu invoice.php
include_once '../../config/database.php';
include_once '../objects/invoice.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu invoice
$invoice = new Invoice($db);

// uzyskanie ID faktury ktora ma zostac edytowana
$data = json_decode(file_get_contents("php://input"));

// ustawienie ID faktury ktora ma byc edytowana
$invoice->id_faktura = $data->id_faktura;

// ustawienie ID statusu
$invoice->id_status = $data->id_status;


// zaktualizowanie faktury
if ($invoice->update($invoice->id_faktura)) {

    // ustawienie kodu odpowiedzi na - 200 OK
    http_response_code(200);

    // wyswietlenie wiadomosci ze udalo sie zaktualizowac statusu
    echo json_encode(array(
        "Sukces" => "Status został zaktualizowany."
    ));
}

// jezeli nie udalo sie zaktualizowac
else {

    // ustawienie kodu odpowiedzi na - 503 service unavailable
    http_response_code(503);

    // wyswietlenie wiadomosci ze nie udalo sie zaktualizowac statusu
    echo json_encode(array(
        "Błąd" => "Nie udalo sie zaktualizowac statusu."
    ));
}
?>
