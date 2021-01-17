<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// dodanie polaczenia z database.php i dodanie obiektu cargo.php
include_once '../../config/database.php';
include_once '../objects/cargo.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu cargo
$cargo = new Cargo($db);

// sprawdzenie czy input jest ustawiony
if (isset($_GET['input']))
    $stmtCargo = $cargo->searchCargo($_GET['input']);// jezeli input jest ustawiony to wyszukujemy po nazwie
else
    $stmtCargo = $cargo->read(); //jesli nie to wyswietlamy wszystko

$num = $stmtCargo->rowCount();

// sprawdzanie czy znaleziono wiecej niz 0 rekordow
if ($num > 0) {

    $cargoArray           = array();
    $cargoArray["Towary"] = array();

    while ($row = $stmtCargo->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $cargoItem = array(
            "id_towar" => $id_towar,
            "nazwa" => $nazwa,
            "cena" => $cena,
            "jednostka_miary" => $jednostka_miary,
            "stawka_vat" => $stawka_vat
        );

        array_push($cargoArray["Towary"], $cargoItem);
    }

    // ustawienie kodu odpowiedzi na - 200 OK
    http_response_code(200);

    // pokazanie towarow w formacie JSON
    echo json_encode($cargoArray);
} else {

    // ustawienie kodu odpowiedzi na - 404 Not found
    http_response_code(404);

    // wyswietlenie wiadomosci ze nie znaleziono towarow
    echo json_encode(array(
        "Błąd" => "Nie znaleziono towarów."
    ));
}

?>
