<?php
class Contractor
{

    // polaczenie z baza i nazwa tabeli w bazie
    private $connection;
    private $table_name = "nabywca";

    // kontrahent
    public $id_nabywca;
    public $nazwa_nabywcy;
    public $adres;
    public $NIP;
    // opcjonalnie
    public $email_nabywcy;


    // konstruktor z polaczeniem
    public function __construct($db)
    {
        $this->connection = $db;
    }


    function read()
    {
        // Zapytanie wyswietlajace wszystkich kontrahentow
        $query = "SELECT * FROM " . $this->table_name;

        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);

        // wykonanie zapytania
        $stmt->execute();

        return $stmt;
    }

    function searchContractor($NIP)
    {
        // zapytanie wyswietlajace kontrahentow po NIP'ie
        $query = "SELECT * FROM nabywca WHERE NIP = '$NIP'";

        // wykonanie zapytania
        $stmt = $this->connection->prepare($query);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    function create()
    {

        // zapytanie do wstawiania rekordu
        $query = "INSERT INTO " . $this->table_name . "
        SET
        nazwa_nabywcy=:nazwa_nabywcy, adres=:adres, NIP=:NIP, email_nabywcy=:email_nabywcy";
        // przygotowanie zapytania
        $stmt  = $this->connection->prepare($query);

        // zabezpieczenie
        $this->nazwa_nabywcy = htmlspecialchars(strip_tags($this->nazwa_nabywcy));
        $this->adres         = htmlspecialchars(strip_tags($this->adres));
        $this->NIP           = htmlspecialchars(strip_tags($this->NIP));
        $this->email_nabywcy = htmlspecialchars(strip_tags($this->email_nabywcy));

        // podłączenie wartości do zapytania
        $stmt->bindParam(":nazwa_nabywcy", $this->nazwa_nabywcy);
        $stmt->bindParam(":adres", $this->adres);
        $stmt->bindParam(":NIP", $this->NIP);
        $stmt->bindParam(":email_nabywcy", $this->email_nabywcy);

        // wykonanie zapytania
        if ($stmt->execute()) {
            return true;
        }

        return false;

    }

    function isValidNIP($NIP){

      if(!is_numeric($NIP)){
        return false;
      }

      if(strlen($NIP)==10){
      $weightArray = array(0 => 6, 5, 7, 2, 3, 4, 5, 6, 7);
      $sum = 0;
      $controlNumber = intval(substr($NIP,-1));
      for($i = 0 ; $i< 9;$i++){
        $sum += (intval($NIP{$i})) * $weightArray[$i];
      }

      return $sum % 11 === $controlNumber;
      }
    }



}
?>
