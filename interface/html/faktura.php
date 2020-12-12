<html lang="pl">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="../css/style.css">
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
					<input type="text" value="Po danych">
					<i class="fas fa-search"></i>
				</div>
			</div>
			<div id="tabelaa">
				<div id="wystaw_faktureb">
					<a href="nowafaktura.php"><i class="fas fa-plus-circle"></i>WYSTAW FAKTURĘ</a>
				</div>
				<div id="tabelka">
					<div id="ttytuly">
						<div id="ttttt">
							<div class="tytulyt1">
								Numer faktury
							</div>
							<div class="tytulyt2">
								Adres
							</div>
							<div class="tytulyt">
								Data wystawienia
							</div>
							<div class="tytulyt">
								Data sprzedaży
							</div>
							<div class="tytulyt">
								Status
							</div>
						</div>
					</div>
					<div id="dane">
						<table class="blueTable">
							<tbody>
							<tr>
							<td id="dnumer">TEST</td>
							<td id="dadres">TEST</td>
							<td id="dwystawienie">TEST</td>
							<td id="dsprzedaz">TEST</td>
							<td id="dstatus">Zapłacona<i class="fas fa-pencil-alt"></i></td></tr>
							<tr>
							<td id="dnumer">TEST</td>
							<td id="dadres">TEST</td>
							<td id="dwystawienie">TEST</td>
							<td id="dsprzedaz">TEST</td>
							<td id="dstatus">Zapłacona<i class="fas fa-pencil-alt"></i></td></tr>
							<tr>
							<td id="dnumer">TEST</td>
							<td id="dadres">TEST</td>
							<td id="dwystawienie">TEST</td>
							<td id="dsprzedaz">TEST</td>
							<td id="dstatus">Zapłacona<i class="fas fa-pencil-alt"></i></td></tr>
							</tbody>
							</tr>
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
