<?php

// dodanie polaczenia z database.php i dodanie obiektu invoice.php
include_once '../../config/database.php';
include_once '../../api/objects/invoice.php';

 $database = new Database();

 $db = $database->getConnection();

 $invoice = new Invoice($db);

 $rok = 2020;
 $stmtGraphStatus = $invoice->graphStatus();
 $stmtGraphMonth = $invoice->graphMonth($rok);

 $invoiceGraphStatus = array();
 $numStatus = $stmtGraphStatus->rowCount();
 $invoiceGraphStatus = $stmtGraphStatus->fetchAll (PDO::FETCH_ASSOC);

 $invoiceGraphMonth = array();
 $numMonth = $stmtGraphMonth->rowCount();
 $invoiceGraphMonth = $stmtGraphMonth->fetchAll (PDO::FETCH_ASSOC);

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
        foreach ($invoiceGraphStatus as $key => $value) {
          echo "['".$value["status_faktury"]."',".$value["ilosc"]."],";
        }
        ?>
      ]);
        var options = {
          title: "Faktury według statusów"
        };
        var chart = new google.visualization.PieChart(document.getElementById('graphStatus'));
        chart.draw(data,options);

        //----------------------------------------------//
        <?php if($numMonth > 0){ ?>
        var data = google.visualization.arrayToDataTable([
          ['miesiac',"ilosc"],
          <?php
          foreach ($invoiceGraphMonth as $key => $value) {
            echo "['".$value["miesiac"]."',".$value["ilosc"]."],";
          }
          ?>
        ]);

          var options = {
            title: "Ilość faktur w miesiącu",
            series: [{'color': '#E7711B'}],
            vAxis: {format: 'short'},
          };
          var chart = new google.visualization.ColumnChart(document.getElementById('graphMonth'));
          chart.draw(data,options);
          <?php } ?>
    }
  </script>
  </head>
  <body>
      <div id="graphStatus" style="width:500px; height:500px; float:left;"></div>
      <div id="graphMonth" style="width:800px; height:500px; float:left;"></div>
  </body>
</html>
