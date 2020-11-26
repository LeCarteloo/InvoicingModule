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

}
?>
