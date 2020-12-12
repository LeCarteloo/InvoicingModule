<?php

// dodanie polaczenia z database.php i dodanie obiektu invoice.php
include_once '../../config/database.php';
include_once '../../api/objects/invoice.php';

 $database = new Database();

 $db = $database->getConnection();

 $invoice = new Invoice($db);

 //$db = mysqli_connect("localhost","root","","fakturowanie");
 $stmtGraphCargo = $invoice->

 $results = mysqli_query($db,$stmtGraphCargo);

?>

<!DOCTYPE html>
<html lang="pl" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>TEST</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart(){
      var data = google.visualization.arrayToDataTable([
        ['status_faktury',"ilosc"],
        <?php
        while($row = mysqli_fetch_array($results)){
          echo "['".$row["status_faktury"]."',".$row["ilosc"]."],";
        }
        ?>
      ]);
        var options = {
          title: "Faktury wg statusÓW"
        };
        var chart = new google.visualization.PieChart(document.getElementById('test'));
        chart.draw(data,options);
    }
  </script>
  </head>
  <body>
    <div style ="width:50%">
      <div id="test" style="width:500px; height:500px;"></div>
    </div>
  </body>
</html>
