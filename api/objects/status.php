<?php
class Status
{

    // polaczenie z baza i nazwa tabeli w bazie
    private $connection;
    private $table_name = "status";

    // status
    public $id_status;
    public $status_faktury;



    // konstruktor z polaczeniem
    public function __construct($db)
    {
        $this->connection = $db;
    }

    function read()
    {
        // zapytanie wyswietlajace wszystkie statusy
        $query = "SELECT * FROM " . $this->table_name;

        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);

        // wykonanie zapytania
        $stmt->execute();

        return $stmt;
    }

}

?>
