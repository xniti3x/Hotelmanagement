<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Reservierungsbestätigung - <?php echo $setting_value; ?></title>

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
			@page { size: landscape;margin: 0; }
			

			</style>
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
					<td  colspan="4">
						<table>
							<tr >
								<td>
									<?php echo $_SESSION["user"]["firma"]; ?><br />
									<?php echo $_SESSION["user"]["strase"]; ?><br />
									<?php echo $_SESSION["user"]["plz"]." ".$_SESSION["user"]["ort"]; ?>
								</td>
								<td  style="text-align: right;">
									<?php echo $user["user_company"]; ?><br />
									<?php echo $user["user_address_1"]; ?><br />
									<?php echo $user["user_zip"]." ".$user["user_city"]; ?><br />
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Bestätigung - Zeitraum: <?php echo date('d-m-Y',strtotime($_SESSION["meta"]["start"]))." - ".date('d-m-Y',strtotime($_SESSION["meta"]["ende"])); ?></td>
					<td>Nächte</td>
					<td>Preis</td>
					<td>Summe</td>
				</tr>
				<?php $total=0; foreach($_SESSION["meta"]["rooms"] as $room){ ?>	
				<tr class="item">
				<td><?php echo($room["kategorie"])." - ".($room["beschreibung"]); ?></td>
				<td><?php echo $days=$_SESSION["meta"]["days"];  ?></td>	
				<td><?php echo ($room["selc_preis"]); ?></td>
				<td><?php echo $preis=($days*$room["selc_preis"]); $total+=$preis;  ?> €</td>
				
				</tr>
				<?php } ?>
				<tr class="total">
					<td></td><td></td><td></td>
					<td><?php echo $total; ?> €</td>
				</tr>
			</table>
			<br><br>Für einen reibungslosen Prozess bitten wir den Betrag auf das unten angezeigte Konto zu überweisen.<br><br>
			<table style="text-align: right; padding-right:50px;">
			<tr>
			<td> <?php echo $user["user_company"]; ?><br /><?php echo $user["user_address_1"]; ?><br /><?php echo $user["user_zip"]." ".$user["user_city"]; ?><br /></td>
			<td><?php echo $user["user_web"]; ?><br>
			<?php echo $user["user_email"]; ?><br><?php echo $user["user_phone"]; ?></td><td><?php echo $user["user_subscribernumber"]; ?><br><?php echo $user["user_iban"]; ?></td><td><?php echo $user["user_vat_id"]; ?><br><?php echo $user["user_tax_code"]; ?></td></tr>
			</table>
<br><br>
<br><br><div align="center">	
	<a href="<?php echo site_url("bookings/index"); ?>" class="button button2">NEU BUCHUNG</a> 
	<a href="" class="button button2" onClick="window.print()">PDF ODER PRINT</a>
</div>
</div>
	</body>
</html>