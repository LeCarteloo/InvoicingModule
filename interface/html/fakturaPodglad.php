<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Faktura podglad</title>
    <link rel="stylesheet" href="../css/fakturaPodglad.css">
  </head>
  <body>
    <?php
     $razem_netto=0;
     $razem_VAT=0;
     $razem_brutto=0;
     //if(isset($_POST['numer_faktury']) && !empty($_POST['numer_faktury']))
       $json = @file_get_contents("http://localhost/Project/api/invoice/readInvoice.php?input=". $_GET['numer_faktury']);

     if($json){

     $arr = json_decode($json);
     $arr2 = json_decode($json, true);
     foreach($arr->Faktury as $key => $value) {

    ?>

    <h2>Faktura VAT Nr <?php echo  $value->numer_faktury ?> </h2>

    <div class="dates">
      <p>Data wystawienia: <b><?php echo  $value->data_wystawienia ?></b></p>
      <p>Data sprzedaży: <b><?php echo  $value->data_sprzedazy ?></b></p>
    </div>

    <div class="seller">
      <p>Sprzedawca</p>
      <p><b>Firma Handlowo Usługowa</b></p>
      <p><b>Rzeszów</b></p>
      <p><b>NIP: 999-999-99-00</b></p>

    </div>
    <div class="contractor">
      <p>Nabywca</p>
      <p><b><?php echo  $value->nazwa_nabywcy ?></b></p>
      <p><b><?php echo  $value->adres ?></b></p>
      <p><b>NIP: <?php echo  $value->NIP ?></b></p>
    </div>
    <table>
      <tr class="tableTitle">
        <th>Lp.</th>
        <th>Nazwa towaru lub usługi</th>
        <th>Ilość</th>
        <th>Jednostka miary</th>
        <th>Cena netto</th>
        <th>Wartość netto</th>
        <th>Stawka VAT</th>
        <th>Kwota VAT</th>
        <th>Wartość brutto</th>
      </tr>
      <?php for($i=0; $i<count($arr2['Faktury'][0]['produkt']['Towary']);$i++){
        $ilosc = $arr2['Faktury'][0]['produkt']['Towary'][$i]['ilosc'];
        $cena_netto = $arr2['Faktury'][0]['produkt']['Towary'][$i]['cena'];
        $VAT = $arr2['Faktury'][0]['produkt']['Towary'][$i]['stawka_vat'];
        $cena_brutto = round($cena_netto * $VAT/100 + $cena_netto,2);
        $wartosc_netto =  $cena_netto * $ilosc;
        $wartosc_vat = ($cena_brutto - $cena_netto) * $ilosc;
        $razem_netto += $wartosc_netto;
        $razem_VAT += $wartosc_vat;
        $razem_brutto += $cena_brutto * $ilosc;

        ?>
      <tr class="tableTitle">
        <td><?php echo $i+1 ?></td>
        <td><?php echo $arr2['Faktury'][0]['produkt']['Towary'][$i]['nazwa']; ?></td>
        <td><?php echo $ilosc; ?></td>
        <td><?php echo $arr2['Faktury'][0]['produkt']['Towary'][$i]['jednostka_miary']; ?></td>
        <td><?php echo $cena_netto . " zł"?></td>
        <td><?php echo $wartosc_netto . " zł"?></td>
        <td><?php echo $VAT . "%"; ?></td>
        <td><?php echo $wartosc_vat . " zł"?></td>
        <td><?php echo $cena_brutto * $ilosc . " zł"?></td>
      </tr>
      <?php } ?>
      <!-- <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="tdBorder">W tym:</td>
        <td class="tdBorder">1000.0</td>
        <td class="tdBorder">23%</td>
        <td class="tdBorder">233.00</td>
        <td class="tdBorder">1233.00</td>
      </tr> -->
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>Razem:</td>
        <td><?php echo $razem_netto . " zł";?></td>
        <td>---</td>
        <td><?php echo $razem_VAT . " zł";?></td>
        <td><?php echo $razem_brutto . " zł";?></td>
      </tr>
    </table>

    <div class="doZaplaty">
      <p>Razem do zaplaty: <b><?php
      if($value->status_faktury == "Nie opłacona")
        echo $razem_brutto . " zł";
     else
        echo "0 zł";?></b> </p>

    </div>

    <div class="forma">
      <p>Forma płatności: <b>Przelew</b> </p>
      <p>Termin płatności: <b>2020-11-30</b> </p>
    </div>

    <div class="rachunek">
      <p>Numer rachunku bankowego sprzedawcy: <b>53123456789707827426232168</b> </p>
    </div>
    <?php
  }
} ?>
    <div class="podpisWystawienie">
      <p>Podpis osoby upoważnionej do wystawienia faktury</p>
    </div>
    <div class="podpisOdbior">
      <p>Podpis osoby upoważnionej do odbioru faktury</p>
    </div>

  </body>
</html>
