<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// dodanie polaczenia z database.php i dodanie obiektu status.php
include_once '../../config/database.php';
include_once '../objects/status.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu status
$status = new Status($db);

$stmtStatus = $status->read();
$num  = $stmtStatus->rowCount();

// sprawdzanie czy znaleziono wiecej niz 0 rekordow
if ($num > 0) {

    $statusArray            = array();
    $statusArray["Statusy"] = array();

    while ($row = $stmtStatus->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $statusItem = array(
            "status_faktury" => $status_faktury
        );

        array_push($statusArray["Statusy"], $statusItem);
    }

    // ustawienie kodu odpowiedzi na  - 200 OK
    http_response_code(200);

    // pokazanie towarow w formacie JSON
    echo json_encode($statusArray);
} else {

    // ustawienie kodu odpowiedzi na - 404 Not found
    http_response_code(404);

    // wyswietlenie wiadomosci ze nie znaleziono statusu
    echo json_encode(array(
        "Bład" => "Nie znaleziono statusów."
    ));
}

?>
