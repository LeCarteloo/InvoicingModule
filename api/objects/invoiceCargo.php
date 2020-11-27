<<?php
class invoiceCargo{

  // database connection and table name from db
  private $connection;
  private $table_name="faktura_towar";

  // properties of objects
  public $id_faktura;
  public $id_towar;
  public $ilosc;

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

function createInvoiceCargo(){

  // query to insert record
  $query = "INSERT INTO
              " . $this->table_name . "
          SET
              id_towar=:id_towar, ilosc=:ilosc, id_faktura=:id_status";
  // prepare query
  $stmt = $this->connection->prepare($query);

  // sanitize
  $this->numer_faktury=htmlspecialchars(strip_tags($this->numer_faktury));
  $this->id_nabywca=htmlspecialchars(strip_tags($this->id_nabywca));
  $this->id_status=htmlspecialchars(strip_tags($this->id_status));
  $this->data_wystawienia=htmlspecialchars(strip_tags($this->data_wystawienia));
  $this->data_sprzedazy=htmlspecialchars(strip_tags($this->data_sprzedazy));

  // bind values
  $stmt->bindParam(":numer_faktury", $this->numer_faktury);
  $stmt->bindParam(":id_nabywca", $this->id_nabywca);
  $stmt->bindParam(":id_status", $this->id_status);
  $stmt->bindParam(":data_wystawienia", $this->data_wystawienia);
  $stmt->bindParam(":data_sprzedazy", $this->data_sprzedazy);

  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;

}


}

?>
