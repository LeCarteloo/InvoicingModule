<<?php
class Invoice{

  // database connection and table name from db
  private $connection;
  private $table_name="faktura";

  // properties of objects
  // faktura
  public $id_faktura;
  public $numer_faktury;
  public $id_status;
  public $data_wystawienia;
  public $data_sprzedazy;
  //Kontrahenci
  public $id_nabywca;
  public $nazwa_nabywcy;
  public $adres;
  public $NIP;
  public $email_nabywcy;
  //Towary
  public $id_towar;
  public $nazwa;
  public $cena;
  public $jednostka_miary;
  public $stawka_vat;
  //Statusy
  public $status_faktury;
  //Faktura_towar laczaca
  public $ilość;



  // constructor with $db as database connection
  public function __construct($db){
    $this->connection = $db;
  }


  function read(){
    // select all query
    $query = "SELECT f.*,n.*,s.*
    FROM faktura f, nabywca n, status s
    WHERE n.id_nabywca = f.id_nabywca
    AND s.id_status = f.id_status";

    // prepare query statement
    $stmt = $this->connection->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }

  function readTEST(){
    // select all query
    $query = "SELECT f.*,ft.*,t.*
    FROM faktura f, faktura_towar ft, towar t
    WHERE f.id_faktura = ft.id_faktura
    AND t.id_towar = ft.id_towar
    AND f.id_faktura = 1";

    // prepare query statement
    $stmt = $this->connection->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
  }

}
?>