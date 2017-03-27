<?php
/*
 * ZAHLUNGSERHALT
 * Speichert in der Datenbank und versendet eine Mail
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

include('../back-end/txt/mail.php');

// Zu erledigende Arbeit
if (!(isset($_POST["nr"]) && isset($_POST["BezArt"]) && isset($_POST["kommi"]))) {
    $error = "Nicht genügend Daten angegeben!";
    include('index.inc.php'); exit;
}
	// Daten Sammeln
	$admin = $user_id;
	$Nummer = mysqli_real_escape_string( $db_link, esc($_POST["nr"]));
	$zahlart1 = mysqli_real_escape_string( $db_link, esc($_POST['BezArt']));
	$zahlart2 = mysqli_real_escape_string( $db_link, esc($_POST['kommi']));
	
// Schonmal ausgefuehrt?
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
	$datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
	
	if ($datensatz["Bezahlt"] == "true") {
		$error = "Vorgang wurde bereits ausgeführt!";
		include('index.inc.php');
		exit;
	}
	
// Ist eine Erklärung vorhanden?
if ( ($zahlart2 == "Bitte genauer beschreiben") || ($zahlart2 == "") ) {
	header ('location: zahlungregistrieren.php?nr='.$Nummer); exit;
} else {
	
	$id = $datensatz['user_id'];
// Ist der User schon geblockt?
	if ( $datensatz['Bezahlt'] == "true" ) {
		$error = "Die Rechnung wurde bereits bezahlt";
		include('index.inc.php'); exit;
	}
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$id' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
	$MailE = $result['Mail'];
	$VornameE = $result['Vorname'];
	$NachnameE = $result['Nachname'];
	// In Datenbank einspeichern
	$date = date("Y-m-d");
	$sql = mysqli_query($db_link, "UPDATE `abi_bestellung` SET `Bezahlt` = 'true', `BezAm` = '$date', `admin_id` = '$admin', `BezArt` = '$zahlart1', `BezKom` = '$zahlart2' WHERE `BestellNr` = '$Nummer';");
	$db_erg = mysqli_query($db_link, $sql);

		
		
// Nachricht senden
	$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";

	// Die Nachricht
	$nachricht = '
	<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.$VornameE.',<br><br>
	  '.encode(str_ireplace("%RechnungsNummer%", $Nummer, $mail_zahlungda)).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$VornameE.' '.$NachnameE.' <br>
	  E-Mail: '.$MailE.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender;

	// Send
	$funzt = mail($empfaenger, 'Deine Bezahlung wurde registriert', $nachricht, $header);

	if ($funzt){$success = "Mail wurde versendet<br>";}
	else {$error = "Es ist zu einem internen Fehler gekommen. Bitte wende Dich an den Webmaster und gib die Nummer ".$Nummer." an. Danke.";}
	include('index.inc.php');
}
