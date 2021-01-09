<?php
class Invoice
{

    // polaczenie z baza i nazwa tabeli w bazie
    private $connection;
    private $table_name = "faktura";

    // faktura
    public $id_faktura;
    public $numer_faktury;
    public $id_status;
    public $data_wystawienia;
    public $data_sprzedazy;
    public $data_platnosci;
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



    // konstruktor z polaczeniem
    public function __construct($db)
    {
        $this->connection = $db;
    }


    function searchInvoice($input)
    {
        // zapytanie ktore służy do wyszukiwaniu po polach
        $query = "SELECT f.*,n.*,s.*
        FROM faktura f, nabywca n, status s
        WHERE n.id_nabywca = f.id_nabywca
        AND s.id_status = f.id_status
        AND (n.NIP LIKE '%" . $input . "%'
          OR  n.nazwa_nabywcy LIKE '%" . $input . "%'
          OR n.email_nabywcy LIKE '%" . $input . "%'
          OR f.numer_faktury LIKE '%" . $input . "%'
          OR f.data_wystawienia LIKE '%" . $input . "%'
          OR f.data_sprzedazy LIKE '%" . $input . "%'
          OR f.data_platnosci LIKE '%" . $input . "%'
          OR s.status_faktury LIKE '%" . $input . "%'
          OR n.adres LIKE '%" . $input . "%')";

        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);

        // wykonanie zapytania
        $stmt->execute();

        return $stmt;
    }

    function endPoint($NIP,$FROM,$TO){
      // zapytanie ktore służy do wyszukiwaniu po polach
      $query = "SELECT f.id_faktura, f.numer_faktury, n.NIP , s.status_faktury, SUM(ft.ilość * t.cena) AS Wartosc_faktury_brutto, f.data_platnosci
      FROM faktura f, nabywca n , status s, faktura_towar ft, towar t
      WHERE f.id_nabywca = n.id_nabywca
      AND f.id_status = s.id_status
      AND ft.id_faktura = f.id_faktura
      AND ft.id_towar = t.id_towar
      AND n.NIP = " . $NIP.
      " AND f.data_wystawienia BETWEEN'" . $FROM . "' AND '" . $TO . "'GROUP BY (f.id_faktura)";

      // przygotowanie zapytania
      $stmt = $this->connection->prepare($query);

      // wykonanie zapytania
      $stmt->execute();

      return $stmt;

    }

    function sortInvoice($input, $column, $type)
    {
        // Zapytanie ktore służy do sortowania w zaleznosci od typu (DESC,ASC) i kolumny
        $query = "SELECT f.*,n.*,s.*
        FROM faktura f, nabywca n, status s
        WHERE n.id_nabywca = f.id_nabywca
        AND s.id_status = f.id_status
        AND (n.NIP LIKE '%" . $input . "%'
          OR n.nazwa_nabywcy LIKE '%" . $input . "%'
          OR n.email_nabywcy LIKE '%" . $input . "%'
          OR f.numer_faktury LIKE '%" . $input . "%'
          OR f.data_wystawienia LIKE '%" . $input . "%'
          OR f.data_sprzedazy LIKE '%" . $input . "%'
          OR f.data_platnosci LIKE '%" . $input . "%'
          OR s.status_faktury LIKE '%" . $input . "%'
          OR n.adres LIKE '%" . $input . "%')
          ORDER BY " . $column . " " . $type;


        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);

        // wykonanie zapytania
        $stmt->execute();

        return $stmt;
    }


    function readCargo($id)
    {
        // Zapytanie wyswietlajace wszystkie towary w zaleznosci od ID faktury
        $query = "SELECT f.*,ft.*,t.*
        FROM faktura f, faktura_towar ft, towar t
        WHERE f.id_faktura = ft.id_faktura
        AND t.id_towar = ft.id_towar
        AND f.id_faktura = " . $id;

        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);

        // wykonanie zapytania
        $stmt->execute();

        return $stmt;
    }

    function create()
    {

        // zapytanie do wstawiania rekordu
        $query = "INSERT INTO " . $this->table_name . "
        SET
        numer_faktury=:numer_faktury, id_nabywca=:id_nabywca, id_status=:id_status, data_wystawienia=:data_wystawienia, data_sprzedazy=:data_sprzedazy,data_platnosci=:data_platnosci";
        // przygotowanie zapytania
        $stmt  = $this->connection->prepare($query);

        // zabezpieczenie
        $this->numer_faktury    = htmlspecialchars(strip_tags($this->numer_faktury));
        $this->id_nabywca       = htmlspecialchars(strip_tags($this->id_nabywca));
        $this->id_status        = htmlspecialchars(strip_tags($this->id_status));
        $this->data_wystawienia = htmlspecialchars(strip_tags($this->data_wystawienia));
        $this->data_sprzedazy   = htmlspecialchars(strip_tags($this->data_sprzedazy));
        $this->data_platnosci   = htmlspecialchars(strip_tags($this->data_platnosci));
        // podłączenie wartości do zapytania
        $stmt->bindParam(":numer_faktury", $this->numer_faktury);
        $stmt->bindParam(":id_nabywca", $this->id_nabywca);
        $stmt->bindParam(":id_status", $this->id_status);
        $stmt->bindParam(":data_wystawienia", $this->data_wystawienia);
        $stmt->bindParam(":data_sprzedazy", $this->data_sprzedazy);
        $stmt->bindParam(":data_platnosci", $this->data_platnosci);

        // wykonanie zapytania
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function update($id)
    {

        // zapytanie do aktualizowania statusu faktury
        $query = "UPDATE " . $this->table_name . "
        SET
        id_status=:id_status
        WHERE id_faktura=" . $id;

        // przygotowanie zapytania
        $stmt = $this->connection->prepare($query);
        // zabezpieczenie
        $this->id_status = htmlspecialchars(strip_tags($this->id_status));

        // podłączenie wartości do zapytania
        $stmt->bindParam(":id_status", $this->id_status);

        // wykonanie zapytania
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function graphStatus(){
      // Zapytanie wyswietlajace wszystkie statusy poszczegolnych faktur
      $query = "SELECT s.status_faktury,
      COUNT(s.status_faktury) as ilosc
      FROM faktura f, status s
      WHERE f.id_status = s.id_status
      GROUP BY s.status_faktury";

      // przygotowanie zapytania
      $stmt = $this->connection->prepare($query);

      // wykonanie zapytania
      $stmt->execute();

      return $stmt;
    }

    function graphMonth($year){
      // Zapytanie wyswietlajace miesiace
      $query = "SELECT MONTHNAME(data_wystawienia) as miesiac,
      COUNT(MONTHNAME(data_wystawienia)) as ilosc
      FROM faktura
      WHERE YEAR(data_wystawienia) = ".$year. "
      GROUP BY MONTHNAME(data_wystawienia)
      ORDER BY data_wystawienia";

      // przygotowanie zapytania
      $stmt = $this->connection->prepare($query);

      // wykonanie zapytania
      $stmt->execute();

      return $stmt;
    }

    function graphCargo(){
      $query = "SELECT t.nazwa, COUNT(ft.id_towar) as Ilosc
      FROM towar t, faktura_towar ft
      WHERE t.id_towar = ft.id_towar
      GROUP BY t.nazwa
      ORDER BY Ilosc DESC LIMIT 5";

      $stmt = $this->connection->prepare($query);

      // wykonanie zapytania
      $stmt->execute();

      return $stmt;
    }

}
?>
