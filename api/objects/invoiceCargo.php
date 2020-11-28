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
              id_towar=:id_towar, ilość=:ilosc, id_faktura=LAST_INSERT_ID()";
  // prepare query
  $stmt = $this->connection->prepare($query);

  // sanitize
  $this->id_towar=htmlspecialchars(strip_tags($this->id_towar));
  $this->ilosc=htmlspecialchars(strip_tags($this->ilosc));

  // bind values
  $stmt->bindParam(":id_towar", $this->id_towar);
  $stmt->bindParam(":ilosc", $this->ilosc);

  // execute query
  if($stmt->execute()){
      return true;
  }

  return false;

}


}

?>
