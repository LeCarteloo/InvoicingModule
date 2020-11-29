<?php
class Cargo
{

    // polaczenie z baza i nazwa tabeli w bazie
    private $connection;
    private $table_name = "towar";

    // towar
    public $id_towar;
    public $nazwa;
    public $cena;
    public $jednostka_miary;
    public $stawka_vat;


    // konstruktor z polaczeniem
    public function __construct($db)
    {
        $this->connection = $db;
    }


    function read()
    {
        // zapytanie wyswietlajace wszystkie towary
        $query = "SELECT * FROM " . $this->table_name;

        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);

        // wykonanie zapytania
        $stmt->execute();

        return $stmt;
    }

    function searchCargo($input)
    {
        // zapytanie ktore służy do wyszukiwaniu po nazwie
        $query = "SELECT * FROM towar
        WHERE nazwa LIKE '%" . $input . "%'";

        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);

        // wykonanie zapytania
        $stmt->execute();

        return $stmt;
    }

    function create()
    {
        // zapytanie do wstawiania rekordu
        $query = "INSERT INTO " . $this->table_name . "
        SET
        nazwa=:nazwa, cena=:cena, jednostka_miary=:jednostka_miary, stawka_vat=:stawka_vat";
        // przygotowanie zapytania
        $stmt  = $this->connection->prepare($query);

        // zabezpieczenie
        $this->nazwa           = htmlspecialchars(strip_tags($this->nazwa));
        $this->cena            = htmlspecialchars(strip_tags($this->cena));
        $this->jednostka_miary = htmlspecialchars(strip_tags($this->jednostka_miary));
        $this->stawka_vat      = htmlspecialchars(strip_tags($this->stawka_vat));

        // podłączenie wartości do zapytania
        $stmt->bindParam(":nazwa", $this->nazwa);
        $stmt->bindParam(":cena", $this->cena);
        $stmt->bindParam(":jednostka_miary", $this->jednostka_miary);
        $stmt->bindParam(":stawka_vat", $this->stawka_vat);

        // wykonanie zapytania
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

}

?>
