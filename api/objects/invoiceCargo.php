<?php
class invoiceCargo
{

    // polaczenie z baza i nazwa tabeli w bazie
    private $connection;
    private $table_name = "faktura_towar";

    /// faktura_towar
    public $id_faktura;
    public $id_towar;
    public $ilosc;

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

    function createInvoiceCargo()
    {

        // zapytanie do wstawiania rekordu
        $query = "INSERT INTO " . $this->table_name . "
        SET
        id_towar=:id_towar, ilość=:ilosc, id_faktura=LAST_INSERT_ID()";
        // przygotowanie zapytania
        $stmt  = $this->connection->prepare($query);

        // zabezpieczenie
        $this->id_towar = htmlspecialchars(strip_tags($this->id_towar));
        $this->ilosc    = htmlspecialchars(strip_tags($this->ilosc));

        // podłączenie wartości do zapytania
        $stmt->bindParam(":id_towar", $this->id_towar);
        $stmt->bindParam(":ilosc", $this->ilosc);

        // wykonanie zapytania
        if ($stmt->execute()) {
            return true;
        }

        return false;
        
    }


}

?>
