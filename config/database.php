<?php
class Database{
private $host = "www.mkwk019.cba.pl";
private $database_name = "carteloo";
private $username = "carteloo";
private $password = "Carteloo223";
public $connection;

  public function getConnection(){
    $this->connection = null;
    try{
      $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->database_name, $this->username, $this->password);
            $this->connection->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Błąd łączenia: " . $exception->getMessage();
        }
        return $this->connection;
  }
}
 ?>
