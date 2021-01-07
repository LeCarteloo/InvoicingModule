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
if (isset($_GET['input'])) {
  // sprawdzenie czy jest ustawiona nazwa kolumny i typ sortowania
    if (isset($_GET['column']) && isset($_GET['type']))
        $stmtInvoice = $invoice->sortInvoice($_GET['input'], $_GET['column'], $_GET['type']); // jezeli typ i kolumna jest ustawiona to wywolujemy funkcje sort
    else
        $stmtInvoice = $invoice->searchInvoice($_GET['input']); // jezeli nie to wyszukujemy po wprowadzonym slowie

    $num = $stmtInvoice->rowCount();

    // sprawdzanie czy znaleziono wiecej niz 0 rekordow
    if ($num > 0) {

        $invoiceArray            = array();
        $invoiceArray["Faktury"] = array();

        while ($row = $stmtInvoice->fetch(PDO::FETCH_ASSOC)) {
            $cargoArray           = array();
            $cargoArray["Towary"] = array();

            extract($row);

            $stmtCargo = $invoice->readCargo($id_faktura);

            while ($row2 = $stmtCargo->fetch(PDO::FETCH_ASSOC)) {
                extract($row2);

                $cargoItem = array(
                    "nazwa" => $nazwa,
                    "cena" => $cena,
                    "jednostka_miary" => $jednostka_miary,
                    "stawka_vat" => $stawka_vat,
                    "ilosc" => $ilość
                );

                array_push($cargoArray["Towary"], $cargoItem);
            }

            $invoiceItem = array(
                "numer_faktury" => $numer_faktury,
                "data_wystawienia" => $data_wystawienia,
                "data_sprzedazy" => $data_sprzedazy,
                "data_platnosci" => $data_platnosci,
                "nazwa_nabywcy" => $nazwa_nabywcy,
                "adres" => $adres,
                "NIP" => $NIP,
                "email_nabywcy" => $email_nabywcy,
                "status_faktury" => $status_faktury,
                "produkt" => $cargoArray
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
