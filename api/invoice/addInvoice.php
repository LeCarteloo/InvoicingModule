<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// dodanie polaczenia z database.php
include_once '../../config/database.php';

// dodanie obiektow invoice.php i invoiceCargo.php
include_once '../objects/invoice.php';
include_once '../objects/invoiceCargo.php';

$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu invoice i invoiceCargo
$invoice      = new Invoice($db);
$invoiceCargo = new invoiceCargo($db);

// uzyskaj dane z pliku JSON
$data = json_decode(file_get_contents("php://input"));

// sprawdzanie czy dane nie sa puste
if (!empty($data->numer_faktury) &&
    !empty($data->id_nabywca) &&
    !empty($data->id_status) &&
    !empty($data->data_wystawienia) &&
    !empty($data->data_sprzedazy) &&
    !empty($data->data_platnosci) &&
    !empty($data->towary)) {

    // ustawienie wartosci faktury
    $invoice->numer_faktury    = $data->numer_faktury;
    $invoice->id_nabywca       = $data->id_nabywca;
    $invoice->id_status        = $data->id_status;
    $invoice->data_wystawienia = $data->data_wystawienia;
    $invoice->data_sprzedazy   = $data->data_sprzedazy;
    $invoice->data_platnosci   = $data->data_platnosci;

    // utworz fakture
    if ($invoice->create()) {

        // ustawienie kodu odpowiedzi na - 201 created
        http_response_code(201);

        // wyswietlenie wiadomosci ze udalo sie stworzyc fakture
        echo json_encode(array(
            "Sukces" => "Faktura została utworzona."
        ));
    }

    // jezeli nie udalo sie stworzyc
    else {

        // ustawienie kodu odpowiedzi na - 503 service unavailable
        http_response_code(503);

        // wyswietlenie wiadomosci ze nie udalo sie stworzyć faktury
        echo json_encode(array(
            "Błąd" => "Nie udało się stworzyć faktury."
        ));
    }

    // dodawanie towarow do faktury
    foreach ($data->towary as $towar) {

        $invoiceCargo->ilosc    = $towar->ilosc;
        $invoiceCargo->id_towar = $towar->id_towar;

        // dodaj towar
        if ($invoiceCargo->createInvoiceCargo()) {

            // ustawienie kodu odpowiedzi na - 201 created
            http_response_code(201);

            // wyswietlenie wiadomosci ze udalo sie dodac towar
            echo json_encode(array(
                "Sukces" => "Towar został dodany do faktury."
            ));
        }

        // jezeli nie udalo sie dodac towaru
        else {

            // ustawienie kodu odpowiedzi na - 503 service unavailable
            http_response_code(503);

            // wyswietlenie wiadomosci ze nie udalo sie dodac towaru
            echo json_encode(array(
                "Błąd" => "Nie udało się dodac towaru."
            ));
        }
    }

}

// jezeli dane sa puste
else {

    // ustawienie kodu odpowiedzi na - 400 bad request
    http_response_code(400);

    // wyswietlenie wiadomosci ze dane sa nie kompletne
    echo json_encode(array(
        "Błąd" => "Nie udalo sie stworzyc faktury, dane sa nie kompletne."
    ));
}
?>
