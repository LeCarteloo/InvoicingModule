<?php

include_once '../../config/database.php';
include_once '../../api/objects/contractor.php';

// uzyskanie polaczenie z baza danych
$database = new Database();
$db       = $database->getConnection();

// zainicjalizowanie obiektu $contractor
$contractor = new Contractor($db);
?>



<html lang="pl">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/kontrahenci.css">
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
					<i class="fas fa-user"></i>Kontrahenci
				</div>
			</div>
			<div id="szukaj">
				<div id="szukajt">
					Wyszukaj
				</div>
				<div id="szukaji">
					<form action="" method="post">
					<input type="text" name="NIP">
					<button class="btn" name="submit"><i class="fas fa-search" type="submit"></i></button>
				</form>
				</div>
			</div>
			<div id="tabelaa">
				<div id="tabelka">
					<div id="ttytuly">
						<div id="ttttt">
						</div>
					</div>
					<div id="dane">
							<table class="blueTable">
                  <thead>
                    <tr>
                      <th scope="col">Nazwa nabywcy</th>
                      <th scope="col">Adres</th>
                      <th scope="col">NIP</th>
                      <th scope="col">E-mail</th>
                    </tr>
                </thead>
                <tbody>
                 <?php
								 	if(isset($_POST['NIP']) && !empty($_POST['NIP']))
										$json = @file_get_contents("http://localhost/Project/api/contractor/readContractor.php?input=".$_POST['NIP']);
									else
								  	$json = @file_get_contents("http://localhost/Project/api/contractor/readContractor.php");

									if($json){

									$arr = json_decode($json);
                  foreach($arr->Kontrahenci as $key => $value) {
                 ?>
                <tr>
                  <th scope="row"><?php echo $value->nazwa_nabywcy; ?></th>
                  <td><?php echo $value->adres; ?></td>
                  <td><?php echo $value->NIP; ?></td>
                  <td><?php echo $value->email_nabywcy; ?></td>
		             </tr>
							   <?php }
							 }
							 else{
								 echo "Nie znaleziono nadawcy o podanym NIP'ie.";
							 }?>
						</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
