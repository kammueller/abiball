<?php
/**
 * KARTENTAUSCH AUFGEBEN 
 * landing page - aktualisiert die entsprechende Karte und gibt eine R�ckmeldung
 */
 
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }

include ('../back-end/txt/mail.php');
include ('../back-end/txt/pages/karten1.php');

// Datenbank zeug
	// Daten ziehen
	$karten_id = mysqli_real_escape_string( $db_link, esc($_POST['hergeben']));
	// Deine Karte?!
	$check = mysqli_query($db_link, "SELECT * FROM `abi_karten` WHERE `id` = '$karten_id';");
	$datensatz = mysqli_fetch_array($check, MYSQL_ASSOC);
	if ($datensatz['user_id'] != $user_id) {
		include('../back-end/design_alpha.inc.php');
		include ('../back-end/design_beta.inc.php');		
		echo '<h1 id="title">Kartentausch</h1>
		Diese Karte gehört nicht dir!!';		/* @TODO CMS */
		include ('../back-end/design_gamma.inc.php');
		exit;
	}
		
	$VorN1 = mysqli_real_escape_string( $db_link, esc($_POST['VorN1']));
	$NachN1 = mysqli_real_escape_string( $db_link, esc($_POST['NachN1']));
	$sql = "UPDATE `abi_karten` SET `Vorname` = '$VorN1', `Nachname` = '$NachN1' WHERE `id` = '$karten_id';";
	$db_erg = mysqli_query($db_link, $sql);
	
// Per Mail benachrichtigen
	$empfaenger = utf8_decode($Vorname." ".$Nachname)." <".$Mail.">";

    $such = array("%KartenID%", "%NeuerInhaber%");
    $ersetz = array($karten_id, utf8_decode($VorN1.' '.$NachN1));
	// Die Nachricht
	$nachricht = '
	<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.utf8_decode($Vorname).',<br><br>
	  '.encode(str_ireplace($such, $ersetz, $mail_karten_tausch)).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.utf8_decode($Vorname.' '.$Nachname).' <br>
	  E-Mail: '.$Mail.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender;

	// Send
	mail($empfaenger, 'Deine Karte wurde umgestellt', $nachricht, $header);

// Content
	
	include('../back-end/design_alpha.inc.php');
	include ('../back-end/design_beta.inc.php');
	
	echo '<h1 id="title">Kartentausch</h1>
	'.encode($bausteine[22]);
	
	include ('../back-end/design_gamma.inc.php');
