<?php

include_once '../../config/database.php';
include_once '../../api/objects/invoice.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu $contractor
$invoice = new Invoice($db);
?>

<html lang="pl">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/style.css">
		<script>
function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("blueTable");
  switching = true;
  // Set the sorting direction to ascending:
  dir = "asc";
  /* Make a loop that will continue until
  no switching has been done: */
  while (switching) {
    // Start by saying: no switching is done:
    switching = false;
    rows = table.rows;
    /* Loop through all table rows (except the
    first, which contains table headers): */
    for (i = 1; i < (rows.length - 1); i++) {
      // Start by saying there should be no switching:
      shouldSwitch = false;
      /* Get the two elements you want to compare,
      one from current row and one from the next: */
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];
      /* Check if the two rows should switch place,
      based on the direction, asc or desc: */
      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      /* If a switch has been marked, make the switch
      and mark that a switch has been done: */
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      // Each time a switch is done, increase this count by 1:
      switchcount ++;
    } else {
      /* If no switching has been done AND the direction is "asc",
      set the direction to "desc" and run the while loop again. */
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
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
					<?php
					if (isset($_POST['nazwa']) && isset($_POST['submit']) && !empty($_POST['nazwa']))
					  $stmtInvoice = $invoice->searchInvoice($_POST['nazwa']);
					else
						$stmtInvoice = $invoice->searchInvoice("");
				//	else
					//  $stmtInvoice = $invoice->sortInvoice();
					?>
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
										<th scope="col" onclick="sortTable(0)">Numer faktury</th>
										<th scope="col" onclick="sortTable(1)">Data wystawienia</th>
										<th scope="col" onclick="sortTable(2)">Data sprzedazy</th>
										<th scope="col" onclick="sortTable(3)">Nazwa nabywcy</th>
										<th scope="col" onclick="sortTable(4)">Adres</th>
										<th scope="col" onclick="sortTable(5)">NIP</th>
										<th scope="col" onclick="sortTable(6)">E-mail</th>
										<th scope="col" onclick="sortTable(7)">Status</th>
									</tr>
							</thead>

							<tbody>
									<?php
									if($num=$stmtInvoice->rowCount() > 0) {
									while ($row = $stmtInvoice->fetch(PDO::FETCH_ASSOC)) {
									?>
											<tr>
												<td><?php echo $row['numer_faktury']; ?></td>
												<td><?php echo $row['data_wystawienia']; ?></td>
												<td><?php echo $row['data_sprzedazy']; ?></td>
												<td><?php echo $row['nazwa_nabywcy']; ?></td>
												<td><?php echo $row['adres']; ?></td>
												<td><?php echo $row['NIP']; ?></td>
												<td><?php echo $row['email_nabywcy']; ?></td>
												<td><?php echo $row['status_faktury']; ?></td>
											</tr>
					<?php }
				}
				else{
					?>
				<div class="test" style="padding:50px">
					Brak towaru o podanej nazwie
				</div>
			<?php } ?>
					</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
