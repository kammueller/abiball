<?php
/*
 * ZAHLUNG REVIDIEREN
 * Die Zahlung einer Rechnung löschen
 * Sicherheitsabfrage vor badaction; Fragt Begründung ab
 *
 * BENÖTIGT höchste Adminrechte
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
		
// Nummer und nochmals Beschreibung heraussuchen
	$Nummer = mysqli_real_escape_string( $db_link, esc($_GET['nr']));
	// Datum, Kartenanzahl
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
	$datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
	$id = $datensatz['user_id'];
	$KartenAnz = 0;
		$k1 = $datensatz['karte1'];
			if ($k1 != 0) { $KartenAnz = 1; };
		$k2 = $datensatz['karte1'];
			if ($k2 != 0) { $KartenAnz = 2; };
		$k3 = $datensatz['karte1'];
			if ($k3 != 0) { $KartenAnz = 3; };
		$k4 = $datensatz['karte1'];
			if ($k4 != 0) { $KartenAnz = 4; };
	$kosten = $KartenAnz * 50;
	$Datum = $datensatz['datum'];
		$Date = date_create($Datum);
		$Datum = date_format($Date, 'd.m.Y');
	$Zahltag = $datensatz['BezAm'];
			$Date = date_create($Zahltag);
			$Zahltag = date_format($Date, 'd.m.Y');
	// Username
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
	$datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
	$user = $datensatz['Vorname']." ".$datensatz['Nachname'];
	
//Content
	echo ("
		<h2>L&ouml;schung der Zahlungsbest&auml;tigung Kartenbestellung ".$Nummer."</h2>
		<p>Die Best&auml;tigung, dass ".$user." die Kosten von ".$kosten.",00 &euro; bezahlt hat, wird nun gel&ouml;scht.<br>
		Die Bestellung wurde am ".$Datum." aufgegeben und am ".$Zahltag." bezahlt.<br><br></p>
		<form name='Zahlung_loeschen_".$Nummer."' action='badaction.php' method='post'>
			<input type='text' size='8' maxlength='12' name='nr' style='display: none;' value='".$Nummer."'>
			<input type='text' size='8' maxlength='20' name='action' style='display: none;' value='revidiereZahlung'>
			Begr&uuml;ndung:<br>
			<textarea name='begruendung' cols='50' rows='10' ></textarea><br>
			<input type='hidden' size='8' maxlength='20' name='action' value='revidiereZahlung'>
			<input type='submit' value='Mail Abschicken'>
		</form> ");
		
	include ('../back-end/design_gamma.inc.php');
	
