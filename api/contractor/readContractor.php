<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// dodanie polaczenia z database.php i dodanie obiektu contractor.php
include_once '../../config/database.php';
include_once '../objects/contractor.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu $contractor
$contractor = new Contractor($db);
if (isset($_GET['input']))
  $stmtContractor = $contractor->searchContractor($_GET['input']);
else
  $stmtContractor = $contractor->read();

$num  = $stmtContractor->rowCount();

// sprawdzanie czy znaleziono wiecej niz 0 rekordow
if ($num > 0) {

    // products array
    $contractorArray                = array();
    $contractorArray["Kontrahenci"] = array();

    while ($row = $stmtContractor->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $contractorItem = array(
            "id_nabywca" => $id_nabywca,
            "nazwa_nabywcy" => $nazwa_nabywcy,
            "adres" => $adres,
            "NIP" => $NIP,
            "email_nabywcy" => $email_nabywcy
        );

        array_push($contractorArray["Kontrahenci"], $contractorItem);
    }

    // ustawienie kodu odpowiedzi na - 200 OK
    http_response_code(200);

    // pokazanie towarow w formacie JSON
    echo json_encode($contractorArray);
} else {

    // ustawienie kodu odpowiedzi na - 404 Not found
    http_response_code(404);

    // wyswietlenie wiadomosci ze nie znaleziono kontrahentow
    echo json_encode(array(
        "Błąd" => "Nie znaleziono kontrahentow."
    ));
}

?>
