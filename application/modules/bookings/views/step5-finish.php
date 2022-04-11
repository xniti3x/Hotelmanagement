<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Reservierungsbestätigung - Companyname</title>

		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}

			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			}

			.invoice-box.rtl table {
				text-align: right;
			}

			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

			.button {
			border: none;
			color: white;
			padding: 16px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			transition-duration: 0.4s;
			cursor: pointer;
			}

			.button1 {
			background-color: white; 
			color: black; 
			border: 2px solid #4CAF50;
			width: 300px;
			}

			.button1:hover {
			background-color: #4CAF50;
			color: white;
			}

			.button2 {
			background-color: white; 
			color: black; 
			border: 2px solid #008CBA;
			}

			.button2:hover {
			background-color: #008CBA;
			color: white;
			}
			</style>
			<style type="text/css" media="print">@page { size: landscape; }</style>
	</head>

	<body>
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title"></td><td></td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									<?php echo $_SESSION["user"]["firma"]; ?><br />
									<?php echo $_SESSION["user"]["strase"]; ?><br />
									<?php echo $_SESSION["user"]["plz"]." ".$_SESSION["user"]["ort"]; ?>
								</td>

								<td>
									Companyname<br />
									companystreet.4<br />
									12345 Berlin
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Bestätigung - Zeitraum: <?php echo date('d-m-Y',strtotime($_SESSION["meta"]["start"]))." - ".date('d-m-Y',strtotime($_SESSION["meta"]["ende"])); ?></td>

					<td>Preis</td>
				</tr>
				<?php $preis=0; foreach($_SESSION["meta"]["rooms"] as $room){ ?>
					
				<tr class="item">
					<td><?php echo($room["kategorie"])." - ".($room["kategorie"]); ?></td>
					<td><?php $preis+=$room["selc_preis"]; echo ($room["selc_preis"]); ?> €</td>
				</tr>
				<?php } ?>
				<tr class="total">
					<td></td>
					<td><?php echo $preis; ?> €</td>
				</tr>
			</table>
			<br><br>Für einen reibungslosen Prozess bitten wir den Betrag auf das unten angezeigte Konto zu überweisen.<br><br>
			<table style="text-align: left;">

<tr><td> Companyname UG<br>
comanystreet.4<br>
81235 Berlin
</td>
<td>&ensp; - companyname.de<br>
&ensp;info@ - companyname.de<br>
&ensp;Tel:012345675
</td><td>&ensp;Bank Volskank<br>&ensp;BIZ:ABCDESF<br>&ensp;IBAN:DE13-23</td><td>&ensp;Berlin<br>&ensp;HRB:1234523<br>&ensp;StNr: 0123456789</td></tr>
</table>
<br><br>
<br><br><div align="center">	
	<a href="<?php echo site_url("bookings/index"); ?>" class="button button2">NEU BUCHUNG</a> 
	<a href="" class="button button2" onClick="window.print()">PDF ODER PRINT</a>
</div>
</div>
<?php usleep(1000000); session_destroy(); ?>
	</body>
</html>