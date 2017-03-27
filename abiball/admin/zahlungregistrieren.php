<?php
/*
 * ZAHLUNG REGISTRIEREN
 * Fragt Zahlungsdetails ab, leitet zu mail.zahlungerhalten weiter
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Nummer und nochmals Beschreibung heraussuchen
	$Nummer = mysqli_real_escape_string( $db_link, esc($_GET['nr']));
	// Datum, Kartenanzahl
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
	$datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
	if(!isset($datensatz)) { //keine gültige Nummer
		echo "<h2>Zahlungseingang Kartenbestellung ".$Nummer."</h2>
		Keine gültige Bestellnummer. <a href='index.php'>Zurück</a>."; include ('../back-end/design_gamma.inc.php'); exit;
	}
	$id = $datensatz['user_id'];
	$KartenAnz = 0;
		$k1 = $datensatz['karte1'];
			if ($k1 != "0") { $KartenAnz = 1; };
		$k2 = $datensatz['karte2'];
			if ($k2 != "0") { $KartenAnz = 2; };
		$k3 = $datensatz['karte3'];
			if ($k3 != "0") { $KartenAnz = 3; };
		$k4 = $datensatz['karte4'];
			if ($k4 != "0") { $KartenAnz = 4; };
	$kosten = $KartenAnz * 50;
	$Datum = $datensatz['datum'];
		$Date = date_create($Datum);
		$Datum = date_format($Date, 'd.m.Y');
	// Username
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
	$datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
	$user = $datensatz['Vorname']." ".$datensatz['Nachname'];
	
//Content
	echo ("
		<h2>Zahlungseingang Kartenbestellung ".$Nummer."</h2>
		<p>Hiermit best&auml;tigst du, dass ".$user." heute die Kosten von ".$kosten.",00 &euro; bezahlt hat.<br>
		Die Bestellung wurde am ".$Datum." aufgegeben und beinhaltete ".$KartenAnz." Karten.<br><br></p>
		<form name='Bezahlung_nr".$Nummer."' action='mail.zahlungerhalten.php' method='post'>
			<input type='text' size='8' maxlength='12' name='nr' style='display: none;' value='".$Nummer."'>
			<select name='BezArt'> <option value='bar'>Barzahlung</option> <option selected value='konto'>Überweisung aufs Konto</option> <option value='sonstige'>Sonstiges</option></select>
			<input type='text' size='64' maxlength='128' name='kommi' value='Bitte genauer beschreiben'>
			<input type='submit' value='Zahlung registrieren'>
		</form> ");
		
	include ('../back-end/design_gamma.inc.php');
	
