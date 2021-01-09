<html lang="pl">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/style.css">
		<script>

function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("blueTable");
  switching = true;
  dir = "asc";
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
					<i class="fas fa-file-invoice-dollar"></i>Faktury
				</div>
			</div>
			<div id="szukaj">
				<div id="szukajt">
					Wyszukaj
				</div>
				<div id="szukaji">
					<form action="" method="post">
					<input type="text" name="nazwa">
					<button class="btn" name="submit"><i class="fas fa-search" type="submit"></i></button>
				</form>
				</div>
			</div>
			<div id="tabelaa">
				<div id="wystaw_faktureb">
					<a href="nowafaktura.php"><i class="fas fa-plus-circle"></i>WYSTAW FAKTURĘ</a>
				</div>
				<div id="tabelka">
					<div id="dane">
						<table class="blueTable" id="blueTable">
							<thead>
									<tr>
										<th style="display: none;"></th>
										<th scope="col" onclick="sortTable(0)">Numer faktury</th>
										<th scope="col" onclick="sortTable(1)">Data wystawienia</th>
										<th scope="col" onclick="sortTable(2)">Data sprzedazy</th>
										<th scope="col" onclick="sortTable(2)">Data płatności</th>
										<th scope="col" onclick="sortTable(3)">Nazwa nabywcy</th>
										<th scope="col" onclick="sortTable(4)">Adres</th>
										<th scope="col" onclick="sortTable(5)">NIP</th>
										<th scope="col" onclick="sortTable(6)">E-mail</th>
										<th scope="col" onclick="sortTable(7)">Status</th>
										<th scope="col">Podgląd</th>
										<th scope="col">Status</th>
									</tr>
							</thead>
							<tbody>
								<?php
								 if(isset($_POST['nazwa']) && !empty($_POST['nazwa']))
									 $json = @file_get_contents("http://localhost/Project/api/invoice/readInvoice.php?input=".$_POST['nazwa']);
								 else
									 $json = @file_get_contents("http://localhost/Project/api/invoice/readInvoice.php?input=");

								 if($json){

								 $arr = json_decode($json);
								 foreach($arr->Faktury as $key => $value) {
								?>
											<tr>
												<td style="display: none;"><?php echo $value->id_faktura; ?></td>
												<td><?php echo $value->numer_faktury; ?></td>
												<td><?php echo $value->data_wystawienia; ?></td>
												<td><?php echo $value->data_sprzedazy; ?></td>
												<td><?php echo $value->data_platnosci; ?></td>
												<td><?php echo $value->nazwa_nabywcy; ?></td>
												<td><?php echo $value->adres; ?></td>
												<td><?php echo $value->NIP; ?></td>
												<td><?php echo $value->email_nabywcy; ?></td>
												<td><?php echo $value->status_faktury; ?></td>
												<td> <?php echo '<a href="fakturaPodglad.php?numer_faktury=' .$value->numer_faktury .'"><button type="button">Podgląd</button></a>'?></td>
												<td><button type="button" id="updateStatus" onclick="updateStatus('<?php echo $value->id_faktura; ?>','<?php echo $value->status_faktury; ?>')">Status</button></td>
											</tr>
					<?php }
					}
					else{
						?>
					</tbody>
					</table>
					<?php
						echo '<div id="brakFaktury">Nie znaleziono faktury</div>';
					}
					?>
					</div>
				</div>
			</div>
		</div>
	</body>

	<script>
		function updateStatus(id,status){
			var status_id=1;
			if(status == "Opłacona")
				status_id = 2;

			var text = `{
    	"id_faktura": ${id},
    	"id_status": ${status_id}
			}`;

			$.ajax({
					type: "POST",
					data :text,
					url: "http://localhost/Project/api/invoice/updateStatus.php",
					contentType: "application/json"
			});
			setTimeout(window.location.reload(true), 1500);
		}
	</script>

</html>
