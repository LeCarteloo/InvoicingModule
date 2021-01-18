<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// dodanie polaczenia z database.php i dodanie obiektu invoice.php
include_once '../../config/database.php';
include_once '../objects/invoice.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu invoice
$invoice = new Invoice($db);

// sprawdzenie czy input jest ustawiony
if (isset($_GET['NIP']) && isset($_GET['Data_od']) && isset($_GET['Data_do'])) {
   $stmtInvoice = $invoice->endPoint($_GET['NIP'],$_GET['Data_od'],$_GET['Data_do']); // jezeli nie to wyszukujemy po wprowadzonym slowie

    $num = $stmtInvoice->rowCount();

    // sprawdzanie czy znaleziono wiecej niz 0 rekordow
    if ($num > 0) {

        $invoiceArray            = array();
        $invoiceArray["Faktury"] = array();

        while ($row = $stmtInvoice->fetch(PDO::FETCH_ASSOC)) {
            extract($row);

            $invoiceItem = array(
                "id_faktura" => $id_faktura,
                "numer_faktury" => $numer_faktury,
                "NIP" => $NIP,
                "status_faktury" => $status_faktury,
                "Wartosc_faktury_brutto" => $Wartosc_faktury_brutto,
                "data_wystawienia" => $data_wystawienia,
            );

            array_push($invoiceArray["Faktury"], $invoiceItem);
        }
        // ustawienie kodu odpowiedzi na - 200 OK
        http_response_code(200);

        // pokazanie faktury w formacie JSON
        echo json_encode($invoiceArray);

    } else {

        // ustawienie kodu odpowiedzi na - 404 Not found
        http_response_code(404);

        // wyswietlenie wiadomosci ze nie znaleziono faktury
        echo json_encode(array(
            "Błąd" => "Nie znaleziono faktur."
        ));
    }
} else {
    echo json_encode(array(
        "Błąd" => "Nie wprowadzono nic w inputa."
    ));
}

?>
