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

<html lang="pl">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/home.css">
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
		<div id="menu">
			<div id="logo">

			</div>
			<div id="menuu">
				<a href="home.php"><div class="wybor">
					<div class="wikona"><i class="fas fa-home"></i></div>
					<div class="wtekst">Start</div></a>
				</div>
        <a href="faktura.php"><div class="wybor">
					<div class="wikona"><i class="fas fa-file-invoice-dollar"></i></div>
					<div class="wtekst">Faktury</div>
				</div></a>
				<a href="kontrahenci.php"><div class="wybor">
					<div class="wikona"><i class="fas fa-user"></i></div>
					<div class="wtekst">Kontrahenci</div></a>
				</div>
				<a href="towary.php"><div class="wybor">
					<div class="wikona"><i class="fas fa-warehouse"></i></div>
					<div class="wtekst">Towary</div></a>
				</div>
			</div>
		</div>
		<div id="content">
			<div id="gdzie">
				<div id="gdzie_tekst">
					<i class="fas fa-home"></i>Start
				</div>
			</div>
			<div id="wykresy" style="margin-left:300px; ">
				<div id="wykresy2" style="width:100%; margin-left:auto; margin-right:auto; min-height:300px;">
					<div id="graphStatus"></div>
		      <div id="graphMonth"></div>
				</div>
			</div>
		</div>
	</body>
</html>
