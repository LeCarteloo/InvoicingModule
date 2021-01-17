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
		<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css"/>
	<style>
		@import "https://use.fontawesome.com/releases/v5.5.0/css/all.css";

		body{
			background-color:#121212 !important;
		}

		.blueTable{
			background-color:#151718 !important;
		}

		.blueTable tr{
			background-color:#151718 !important;
		}


		#example_wrapper{

		}

		#example_length{
			color:#fff;
		}

		#example_length select{
			color:#fff;
			background-color:#000;
		}

		#example_filter{
			color:#fff;
		}

		#example_filter input{
			background-color:black;
			color:#fff;
			border:1px solid #fff;
		}

		#example_info{
			color:#fff;
		}

		.modal-header button{
			color:white !important;
			font-size:30px !important;
		}

		#example_previous{
			color:#fff !important;
			cursor:pointer;
		}

		#example_next{
			color:#fff !important;
			cursor:pointer;
		}

		.modal-footer button{
			background-color:#00d6ac;
			border:0px;
			color:#fff;
			font-size:16px;
		}

		.dataTables_empty{
			color:#fff;
		}

		tbody tr{
			background-color:#121212 !important;
			color:#fff;
		}

		.modal-content{
			min-height:370px !important;
		}

		tr{
			color:#fff !important;
		}

		#modal_gora .close{
			color:#fff !important;
			font-size:40px !important;

		}
	</style>
	<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
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
					<div class="wtekst">Faktury</div></a>
				</div>
				<a href="kontrahenci.php"><div class="wybor">
					<div class="wikona"><i class="fas fa-user"></i></div>
					<div class="wtekst">Kontrahenci</div>
				</div></a>
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

				<div id="dane13">
					<div id="data_wystawienia">
						<div class="tnumer2ggg">
							Data sprzedaży
						</div>
						<div class="inumer" id="sprzedaz">
							<input type="date" name="" value="" id="sprzedazINPUT">
						</div>
					</div>

					<div id="data_wystawienia">
						<div class="tnumer2ggg">
							Data wystawienia
						</div>
						<div class="inumer">
							<input type="date" name="" value="<?php echo date("Y-m-d"); ?>" id="data_wystawieniaC" disabled>
						</div>
					</div>

					<div id="data_wystawienia">
						<div class="tnumer2ggg">
							Data płatności
						</div>
						<div class="inumer">
							<input type="date" name="" value="" id="platnosc">
						</div>
					</div>
				</div>

				<div id="danel1">
					<div id="numer_faktury">
						<div class="tnumer">
							Numer faktury
						</div>
						<div class="inumer">
							<input type="text" id="nr_faktury" name="" value="<?php
							$query = "SELECT COUNT(*) as ilosc FROM faktura WHERE data_wystawienia = CURDATE()";
							$stmt = $db->prepare($query);

							$stmt->execute();

							$last_ID = $stmt->fetch(PDO::FETCH_ORI_FIRST);

							// $last_ID =
							//
							// $numer_faktury =
							echo $last_ID['ilosc']+1 . "/" . date("Y/md");
							?>" disabled>

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
						<i class="fas fa-plus-circle" onclick="poka2()"></i>
					</div>

				</div>

			</div>
						<!-- The Modal -->
						<div id="myModal2" class="modal">

						  <!-- Modal content -->
							<div class="modal-content2">
								<div id="modal_gora">
								<i class="fas fa-user-plus"></i><div id="modal_gtekst">DODAJ KONTRAHENTA</div>
								<span id="clll" class="close" onclick="schowaj2()">&times;</span>
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

											$curl = curl_init();

											curl_setopt($curl,CURLOPT_URL,"http://localhost/Project/api/cargo/addContractorFromJSON.php?nip=" .$_POST['NIP']);

											curl_exec($curl);

											$json = @file_get_contents("http://localhost/Project/api/contractor/readContractor.php?input=".$_POST['NIP']);

											$curl = curl_init();

											curl_setopt($curl,CURLOPT_URL,"http://localhost/Project/api/cargo/addCargoFromJSON.php");

											curl_exec($curl);


											if(@$json){

											$arr = json_decode($json);
											foreach($arr->Kontrahenci as $key => $value){
												echo "<script>
												var id_nabywca = $value->id_nabywca;
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

					<table id="cargos" class="blueTable">
						<thead>
						<tr>
						<th style="display: none;"></th>
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
						<td style="display: none;"> <input type="hidden" id="id1" value=""> </td>
						<td><div class="t2" id="lp1">1</div></td>
						<td><div class="drugiet"><div class="tx" id="nazwa_towaru1">-</div><i class="fas fa-search" data-toggle="modal" data-target="#myModal"></i></div></td>
						<td><div class="t1" id="jednostka_miary1">-</div></td>
						<td><div class="t1">  <input type="number" id="iloscWybierz1" onchange="ilosc(1)"> </div></td>
						<td><div class="t1" id="cena_netto1">-</div></td>
						<td><div class="t1" id="stawka_vat1">-</div></td>
						<td><div class="t1" id="wartosc_netto1">-</div></td>
						<td><div class="t1" id="wartosc_vat1">-</div></td>
						<td><div class="t1" id="wartosc_brutto1">-</div></td>
						<td><div class="t3" ></div></td>
						<!-- <button id="delete" type="button" name="button"><i class="fas fa-times"></i></button> -->
						</tr>


						</tbody>
					</table>

					<div id="podsumowanie">
						<div id="dodaj_pozycje">
							<i class="fas fa-plus-circle"></i><div id="dodaj_pozycjet">Dodaj pozycję</div>
						</div>
						<div id="podsumowanie_ceny">
							<div id="cbrutto">
								-
							</div>
							<div id="cvat">
								-
							</div>
							<div id="cnetto">
								-
							</div>
							<div id="csuma">
								Suma
							</div>
						</div>

					</div>
				</div>
				<div id="data_wystawienia_radio">
					<div class="tnumer">
						Status faktury
					</div>
					<div class="inumer">
						<input type="radio" name="status_faktury" value="1" id="oplacona">
						<label>Opłacona</label><br>
						<input type="radio" name="status_faktury" value="2" id="nie_oplacona" checked>
						<label>Nie opłacona</label><br>
					</div>
				</div>

					<button type="button" id="przyciskfaktura" name="createInvoice" onclick="createInvoice()">Stwórz fakture</button>
			</div>




										<!-- Modal -->
							<div id="myModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content"  style="background-color: #121212; color:#fff; font-family:'Segoe UI';">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title"><i class="fab fa-product-hunt" style="float:left; margin-right:10px; margin-left:10px; font-size:35px;"></i><div id="modal_gtekst" style="float:left; font-size:25px;">WYBIERZ TOWAR</div></h4>
								  </div>
								  <div class="modal-body">
								   <div class="table-responsive">
									  <table id="example">
										<thead>
										  <tr>
										  <th style="display: none;"></th>
										  <th>Nazwa</th>
										  <th>Jednostka miary</th>
										  <th>Cena brutto</th>
										  <th>Stawka VAT</th>
										  <th>Akcja</th>
										  </tr>
										</thead>
										<tbody>
										  <?php
												$json = @file_get_contents("http://localhost/Project/api/cargo/readCargo.php");

										  if($json){

										  $arr = json_decode($json);
										   foreach($arr->Towary as $key => $value) {
										  ?>
										  <tr>
											<td style="display: none;"><?php echo $value->id_towar; ?> </td>
											<td scope="row" style="text-align: center;"><?php echo $value->nazwa; ?></td>
											<td style="text-align: center;"><?php echo $value->jednostka_miary; ?></td>
											<td style="text-align: center;"><?php echo $value->cena; ?></td>
											<td style="text-align: center;"><?php echo $value->stawka_vat; ?></td>
											<td style="text-align: center;">
											<div class="TEST"><button type="button" name="wybierz" class="btn btn-success" onclick="wybierz(1)">Wybierz</button></div>
											</tr>
										 <?php }
									 }
									 else{
									   echo '<div id="bbb" style="text-align:center; width:100%; height:50px; font-size:20px;">Nie znaleziono towaru o podanej nazwie.</div>';
									 }?>
										</tbody>
									  </table>
									</div>
								  </div>
								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">ZAMKNIJ</button>
								  </div>
								</div>

							  </div>
							</div>
		</div>

		<div class="center">
				<div class="content">
					<div class="header">
						<h2>Błąd</h2>
						<div class="close-icon"><label for="click" class="fas fa-times"></label></div>
					</div>
					<label for="click" class="fas fa-check-circle fa-4x"></label>
					<p class = "text">Wypełnij wszystkie pola!</p>
					<div class="line"></div>
					<label for="click" class="close-btn">Zamknij</label>
				</div>
			</div>

<script>
let suma_netto=0,suma_vat=0,suma_brutto=0;
let cena;
function wybierz(index){
 var table = document.getElementById('example');
 for(var i = 1; i < table.rows.length; i++)
{
 table.rows[i].onclick = function()
 {
			//rIndex = this.rowIndex;
		 cena = parseFloat(this.cells[3].innerHTML);
		 var vat = parseInt(this.cells[4].innerHTML);
		 var cena_netto = cena - ((cena*vat)/(100+vat)).toFixed(2);
		 	document.getElementById("id"+index).value = this.cells[0].innerHTML;
			document.getElementById("nazwa_towaru"+index).innerHTML = this.cells[1].innerHTML;
			document.getElementById("jednostka_miary"+index).innerHTML = this.cells[2].innerHTML;
			document.getElementById("cena_netto"+index).innerHTML = cena_netto + 'zł';
			document.getElementById("stawka_vat"+index).innerHTML = this.cells[4].innerHTML + '%';

			if(document.getElementById(`nazwa_towaru${rowIndex}`).innerHTML=="-")
				document.getElementById(`iloscWybierz${rowIndex}`).disabled = true;
			else
				document.getElementById(`iloscWybierz${rowIndex}`).disabled = false;

 };
}
}

function ilosc(index){
var cena_netto = parseFloat(document.getElementById("cena_netto"+index).innerHTML);
var vat = parseInt(document.getElementById("stawka_vat"+index).innerHTML);
var ilosc = document.getElementById("iloscWybierz"+index).value;
var wartosc_netto = (cena_netto * ilosc).toFixed(2);
document.getElementById("wartosc_netto"+index).innerHTML = wartosc_netto + 'zł';
document.getElementById("wartosc_vat"+index).innerHTML = ((cena - cena_netto) * ilosc).toFixed(2) + 'zł';
document.getElementById("wartosc_brutto"+index).innerHTML = cena * ilosc + 'zł';

suma_netto+=parseFloat(wartosc_netto);
suma_vat+=parseFloat(((cena - cena_netto) * ilosc).toFixed(2));
suma_brutto+=parseFloat(cena * ilosc);
document.getElementById("cvat").innerHTML = suma_vat.toFixed(2) + 'zł';
document.getElementById("cnetto").innerHTML = suma_netto.toFixed(2) + 'zł';
document.getElementById("cbrutto").innerHTML = suma_brutto.toFixed(2) + 'zł';
}


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


	var table= $('#example').DataTable();
	var tableBody = '#example tbody';

		$(tableBody).on('click', 'tr', function () {
	var cursor = table.row($(this));//get the clicked row
	var data=cursor.data();// this will give you the data in the current row.
		$('form').find("input[name='Name'][type='text']").val(data[0]);
	$('form').find("input[name='Bday'][type='text']").val(data[1]);
	$('form').find("input[name='Age'][type='number']").val(data[2]);
	} );

	let rowIndex = 1;

$("#dodaj_pozycje").click(function () {
	$('#delete').remove();
	rowIndex++;
  $('#cargos tr:last').after(`<tr id="todleglosc">
	<td style="display: none;"> <input type="hidden" id="id${rowIndex}" value=""> </td>
	<td><div class="t2" id="lp${rowIndex}">${rowIndex}</div></td>
	<td><div class="drugiet"><div class="tx" id="nazwa_towaru${rowIndex}">-</div><i class="fas fa-search" data-toggle="modal" data-target="#myModal"></i></div></td>
	<td><div class="t1" id="jednostka_miary${rowIndex}">-</div></td>
	<td><div class="t1">  <input type="number" id="iloscWybierz${rowIndex}" onchange="ilosc(${rowIndex})"> </div></td>
	<td><div class="t1" id="cena_netto${rowIndex}">-</div></td>
	<td><div class="t1" id="stawka_vat${rowIndex}">-</div></td>
	<td><div class="t1" id="wartosc_netto${rowIndex}">-</div></td>
	<td><div class="t1" id="wartosc_vat${rowIndex}">-</div></td>
	<td><div class="t1" id="wartosc_brutto${rowIndex}">-</div></td>
	<td><div class="t3" id="delButton${rowIndex}"><button id="delete" type="button" name="button"><i class="fas fa-times"></i></button></div></td>
	</tr>`);

	$('.TEST').html(`<button type="button" name="wybierz" class="btn btn-success" onclick="wybierz(${rowIndex})">Wybierz</button>`);

		document.getElementById(`iloscWybierz${rowIndex}`).disabled = true;

});

$("#cargos").on('click', '#delete', function () {
		var wartosc_n = parseFloat(document.getElementById("wartosc_netto"+rowIndex).innerHTML);
		var wartosc_v = parseFloat(document.getElementById("wartosc_vat"+rowIndex).innerHTML);
		var wartosc_b = parseFloat(document.getElementById("wartosc_brutto"+rowIndex).innerHTML);
    $(this).closest('tr').remove();

		suma_netto-=wartosc_n;
		suma_vat-=wartosc_v;
		suma_brutto-=wartosc_b;
		document.getElementById("cvat").innerHTML = suma_vat.toFixed(2) + 'zł';
		document.getElementById("cnetto").innerHTML = suma_netto.toFixed(2) + 'zł';
		document.getElementById("cbrutto").innerHTML = suma_brutto.toFixed(2) + 'zł';

		rowIndex--;
		$(`#delButton${rowIndex}`).html(`<button id="delete" type="button" name="button"><i class="fas fa-times"></i></button>`);


});

function createInvoice(){
	var numer_faktury = document.getElementById("nr_faktury").value;
	var nip = document.getElementById("NIP").innerHTML;
	var data_wystawienia = document.getElementById("data_wystawieniaC").value;
	var data_platnosci = document.getElementById("platnosc").value;
	var data_sprzedazy = document.getElementById("sprzedazINPUT").value;
	var oplacona = document.getElementById("oplacona").checked;
	var nie_oplacona = document.getElementById("nie_oplacona").checked;
	var status;
	if(oplacona==true)
		status = 1;
	else
		status = 2;

		var text = `{
            "numer_faktury": "${numer_faktury}",
            "id_nabywca": ${id_nabywca},
            "id_status": ${status},
            "data_wystawienia": "${data_wystawienia}",
            "data_sprzedazy": "${data_sprzedazy}",
            "data_platnosci": "${data_platnosci}",
            "towary":[`;
							for(var i=1;i<=rowIndex;i++){
								ilosc = document.getElementById("iloscWybierz"+i).value;
								id = document.getElementById("id"+i).value;
								if(i>1)
									text += ","

								text += `{
                "ilosc": ${ilosc},
                "id_towar": ${id}
								}`;

							}

		text += "  ] }";

		console.log(text);
		$.ajax({
				type: "POST",
				data :text,
				url: "http://localhost/Project/api/invoice/addInvoice.php",
				contentType: "application/json"
		});


window.location.reload(true);
}

				$("#przyciskfaktura").click(function(){
			   $('.content').toggleClass("show");
			   $('#zalozKonto').addClass("disabled");});
				 $('.close-icon').click(function(){
				$('.content').toggleClass("show");
			});
			$('.close-btn').click(function(){
				$('.content').toggleClass("show");
			});

			if(document.getElementById(`nazwa_towaru${rowIndex}`).innerHTML=="-")
				document.getElementById(`iloscWybierz${rowIndex}`).disabled = true;
			else
				document.getElementById(`iloscWybierz${rowIndex}`).disabled = false;
</script>


	</body>
</html>
