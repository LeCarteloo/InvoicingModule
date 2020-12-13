<?php

include_once '../../config/database.php';
include_once '../../api/objects/cargo.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu $contractor
$cargo = new Cargo($db);
?>

<html lang="pl">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/towary.css">
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
					<i class="fas fa-warehouse"></i>Towary
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
					  $stmtCargo = $cargo->searchCargo($_POST['nazwa']);
					else
					  $stmtCargo = $cargo->read();
					?>

				</form>
				</div>
			</div>
			<div id="tabelaa">
				<div id="tabelka">
					<div id="dane">
						<table class="blueTable">
								<thead>
									<tr>
										<th scope="col">Nazwa towaru</th>
										<th scope="col">Cena</th>
										<th scope="col">Jednostka miary</th>
										<th scope="col">Stawka VAT</th>
									</tr>
							</thead>

							<tbody>
									<?php
									if($num=$stmtCargo->rowCount() > 0) {
									while ($row = $stmtCargo->fetch(PDO::FETCH_ASSOC)) {
									?>
											<tr>
													<th scope="row"><?php echo $row['nazwa']; ?></th>
													<td><?php echo $row['cena']; ?></td>
													<td><?php echo $row['jednostka_miary']; ?></td>
													<td><?php echo $row['stawka_vat']; ?></td>
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
