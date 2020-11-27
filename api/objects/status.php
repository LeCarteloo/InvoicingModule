<<?php
class Status{

  // database connection and table name from db
  private $connection;
  private $table_name="status";

  // properties of objects
  public $id_status;
  public $status_faktury;



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
