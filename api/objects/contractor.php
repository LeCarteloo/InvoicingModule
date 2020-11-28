<<?php
class Contractor{

  // database connection and table name from db
  private $connection;
  private $table_name="nabywca";

  // properties of objects
  public $id_nabywca;
  public $nazwa_nabywcy;
  public $adres;
  public $NIP;
  // optional
  public $email_nabywcy;


  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }

  // read products
  function read(){
    // select all query
    $query = "SELECT * FROM "  . $this->table_name;

    // prepare query statement
    $stmt = $this->connection->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }

  function getContractor($NIP){
    // select all query
    $query = "SELECT * FROM nabywca WHERE NIP = '$NIP'";

    // prepare query statement
    $stmt = $this->connection->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }

  function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                nazwa_nabywcy=:nazwa_nabywcy, adres=:adres, NIP=:NIP, email_nabywcy=:email_nabywcy";
    // prepare query
    $stmt = $this->connection->prepare($query);

    // sanitize
    $this->nazwa_nabywcy=htmlspecialchars(strip_tags($this->nazwa_nabywcy));
    $this->adres=htmlspecialchars(strip_tags($this->adres));
    $this->NIP=htmlspecialchars(strip_tags($this->NIP));
    $this->email_nabywcy=htmlspecialchars(strip_tags($this->email_nabywcy));

    // bind values
    $stmt->bindParam(":nazwa_nabywcy", $this->nazwa_nabywcy);
    $stmt->bindParam(":adres", $this->adres);
    $stmt->bindParam(":NIP", $this->NIP);
    $stmt->bindParam(":email_nabywcy", $this->email_nabywcy);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

}


}
?>
