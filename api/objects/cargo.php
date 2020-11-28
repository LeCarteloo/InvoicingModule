<<?php
class Cargo{

  // database connection and table name from db
  private $connection;
  private $table_name="towar";

  // properties of objects
  public $id_towar;
  public $nazwa;
  public $cena;
  public $jednostka_miary;
  public $stawka_vat;


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

function searchCargo($input){
  // select all query
  $query = "SELECT *
  FROM towar
  WHERE nazwa LIKE '%".$input."%')";

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
              nazwa=:nazwa, cena=:cena, jednostka_miary=:jednostka_miary, stawka_vat=:stawka_vat";
  // prepare query
  $stmt = $this->connection->prepare($query);

  // sanitize
  $this->nazwa=htmlspecialchars(strip_tags($this->nazwa));
  $this->cena=htmlspecialchars(strip_tags($this->cena));
  $this->jednostka_miary=htmlspecialchars(strip_tags($this->jednostka_miary));
  $this->stawka_vat=htmlspecialchars(strip_tags($this->stawka_vat));

  // bind values
  $stmt->bindParam(":nazwa", $this->nazwa);
  $stmt->bindParam(":cena", $this->cena);
  $stmt->bindParam(":jednostka_miary", $this->jednostka_miary);
  $stmt->bindParam(":stawka_vat", $this->stawka_vat);

  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;

}

}

?>
