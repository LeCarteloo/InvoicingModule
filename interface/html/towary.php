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
								if(isset($_POST['nazwa']) && !empty($_POST['nazwa']))
									$json = @file_get_contents("http://localhost/Project/api/cargo/readCargo.php?input=".$_POST['nazwa']);
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
			             </tr>
								 <?php }
			 				}
			 				else{
			 					echo "Nie znaleziono towaru o podanej nazwie.";
			 				}?>
					</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
