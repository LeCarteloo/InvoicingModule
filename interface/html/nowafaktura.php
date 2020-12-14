<?php

include_once '../../config/database.php';
include_once '../../api/objects/invoice.php';
include_once '../../api/objects/contractor.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu $contractor
$invoice = new Invoice($db);
$contractor = new Contractor($db);

?>
<html lang="pl">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/nowafaktura.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script>
			$("#formTest").click(function(){
				$("#tabela_towary").load("#tabela_towary");
			});
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
					<i class="fas fa-file-invoice-dollar"></i>Nowa faktura
				</div>
			</div>
			<div id="dane">
				<div id="danel1">
					<div id="numer_faktury">
						<div class="tnumer">
							Numer faktury
						</div>
						<div class="inumer">
							<?php
							$query = "SELECT COUNT(*) as ilosc FROM faktura WHERE data_wystawienia = CURDATE()";
							$stmt = $db->prepare($query);

				      $stmt->execute();

							$last_ID = $stmt->fetch(PDO::FETCH_ORI_FIRST);

							// $last_ID =
							//
							// $numer_faktury =
							echo $last_ID['ilosc']+1 . "/" . date("Y/md");
							?>

						</div>
					</div>

					<div id="data_wystawienia">
						<div class="tnumer">
							Data wystawienia
						</div>
						<div class="inumer">
							<?php echo date("d.m.Y"); ?>
						</div>
					</div>
				</div>
				<div id="danel2">
					<div id="numer_faktury">
						<div class="tnumer">
							Nazwa nabywcy
						</div>
						<div class="inumer" id="nazwa_nabywcy">

						</div>
					</div>

					<div id="numer_NIP">
						<div class="tnumer2">
							NIP
						</div>
						<div class="inumer" id="NIP">

						</div>
					</div>

					<div id="adres">
						<div class="tnumer3">
							Adres
						</div>
						<div class="inumer3" id="adres_nabywcy">

						</div>
						<i class="fas fa-plus-circle" onclick="poka()"></i>
					</div>

					<div id="data_wystawienia">
						<div class="tnumer">
							Data sprzedaży
						</div>
						<div class="inumer">
							<input type="date" name="data_sprzedazy" >
						</div>
					</div>
				</div>

			</div>
						<!-- The Modal -->
						<div id="myModal" class="modal">

						  <!-- Modal content -->
							<div class="modal-content">
								<div id="modal_gora">
								<i class="fas fa-user-plus"></i><div id="modal_gtekst">DODAJ KONTRAHENTA</div>
								<span class="close" onclick="schowaj()">&times;</span>
								</div>
								<div id="modal_srodek">
									<div id="srodek_tekst">
										Podaj NIP kontrahenta
									</div>
									<div id="srodek_input">
										<div id="srodek_t">
											NIP
										</div>
										<form class="" method="post">
										<input type="text" name="NIP">
										</form>
										<?php
	 								 	if(isset($_POST['NIP']) && !empty($_POST['NIP']))
										{
	 										$json = @file_get_contents("http://localhost/Project/api/contractor/readContractor.php?input=".$_POST['NIP']);

		 									if(@$json){

		 									$arr = json_decode($json);
											foreach($arr->Kontrahenci as $key => $value){
												echo "<script>
												document.getElementById('nazwa_nabywcy').innerHTML = '$value->nazwa_nabywcy';
												document.getElementById('NIP').innerHTML = '$value->NIP';
												document.getElementById('adres_nabywcy').innerHTML = '$value->adres';
												 </script>";
											 	}
											}
											else { // jezeli nie ma w naszej bazie nadawcy o podanym NIP to pobieramy
												// z bazy Kontrahentow
												echo "Nie znaleziono nadawcy o podanym NIP.";
											}
										}
										?>
									</div>
								</div>
								<div id="modal_dol">
									<div id="dolb">
										SPRAWDŹ BAZE
									</div>
								</div>
							</div>

						</div>

			<div id="towary">
				<div id="towary2">

					<table class="blueTable">
						<thead>
						<tr>
						<th>Lp</th>
						<th>Nazwa towaru</th>
						<th>Jednostka miary</th>
						<th>Ilość</th>
						<th>Cena netto</th>
						<th>Stawka VAT</th>
						<th>Wartość netto</th>
						<th>Wartość VAT</th>
						<th>Wartość brutto</th>
						</tr>
						</thead>
						<tbody>
						<tr id="todleglosc">
						<td><div class="t2">1</div></td>
						<td><div class="drugiet"><div class="tx">Rower duży 4 koła</div><i class="fas fa-search" onclick="poka2()"></i></div></td>
						<td><div class="t1">sztuk</div></td>
						<td><div class="t1">1</div></td>
						<td><div class="t1">1200zł</div></td>
						<td><div class="t1">20%</div></td>
						<td><div class="t1">1300zł</div></td>
						<td><div class="t1">500zł</div></td>
						<td><div class="t1">4000zł</div></td>
						<td><div class="t3"><i class="fas fa-times"></i></div></td>
						</tr>
						</tbody>
					</table>
					<div id="podsumowanie">
						<div id="dodaj_pozycje">
							<i class="fas fa-plus-circle"></i><div id="dodaj_pozycjet">Dodaj pozycję</div>
						</div>
						<div id="podsumowanie_ceny">
							<div id="cbrutto">
								00.00zł
							</div>
							<div id="cvat">
								00.00zł
							</div>
							<div id="cnetto">
								00.00zł
							</div>
							<div id="csuma">
								Suma
							</div>
						</div>

					</div>
				</div>
			</div>


			<div id="myModal2" class="modal">

						  <!-- Modal content -->
							<div class="modal-content2">
								<div id="modal_gora">
								<i class="fab fa-product-hunt"></i></i><div id="modal_gtekst">WYBIERZ TOWAR</div>
								<span class="close" onclick="schowaj2()">&times;</span>
								</div>
								<div id="modal_srodek2">
									<div id="srodek_tekst">
										Wyszukaj
									</div>
										<div id="szukaji">
											<form action="" method="post">
											<input type="text" name="wyszukaj_towary">
											<button type="button" name="submit" id="formTest"><i class="fas fa-search" type="submit"></i></button>
											</form>
									</div>
									<table class="blueTable2" id="tabela_towary">
										<thead>

										<tr>
										<th>Nazwa</th>
										<th>Jednostka miary</th>
										<th>Cena netto</th>
										<th>Stawka VAT</th>
										<th>Akcja</th>
										</tr>
										</thead>
										<tbody>
											<?php
											if(isset($_POST['wyszukaj_towary']) && !empty($_POST['wyszukaj_towary']))
												$json = @file_get_contents("http://localhost/Project/api/cargo/readCargo.php?input=".$_POST['wyszukaj_towary']);
											else
												$json = @file_get_contents("http://localhost/Project/api/cargo/readCargo.php");

											if($json){

											$arr = json_decode($json);
											 foreach($arr->Towary as $key => $value) {
											?>
											<tr>
			                  <th scope="row"><?php echo $value->nazwa; ?></th>
			                  <td><?php echo $value->cena; ?></td>
			                  <td><?php echo $value->jednostka_miary; ?></td>
			                  <td><?php echo $value->stawka_vat; ?></td>
												<td><button type="button" name="wybierz">Wybierz</button></td>
					             </tr>
										 <?php }
								 }
								 else{
									 echo "Nie znaleziono towaru o podanej nazwie.";
								 }?>
										</tbody>
									</table>
									<div id="modal_dol2">
										<div id="dolb2" onclick="schowaj2()">
											ZAMKNIJ
										</div>
									</div>
								</div>
							</div>

						</div>

		</div>




<script>
	var modal = document.getElementById("myModal");
	var modal2 = document.getElementById("myModal2");

	function poka() {
	  modal.style.display = "block";
	}

	function schowaj() {
	  modal.style.display = "none";
	}

	function poka2() {
	  modal2.style.display = "block";
	}

	function schowaj2() {
	  modal2.style.display = "none";
	}

	/*
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
	}*/

</script>


	</body>
</html>
