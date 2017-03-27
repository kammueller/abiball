<?php
include('back-end/txt/mail.php');


if (!(isset($db_link) && isset($Vorname))) { echo "Schwerwiegender Fehler."; exit; }


// User-ID abfragen
	$sql = "SELECT * FROM `abi_user` WHERE `Vorname` LIKE '$Vorname' AND `Nachname` LIKE '$Nachname' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQLI_ASSOC);
	$id = $result['id'];
// Verifizierungslink erstellen
	$verify = md5(rand(999, 999999));
	$sql = "INSERT INTO `abi_verify` (`user_id`, `hash`) VALUES ('$id', '$verify')";
	$db_erg = mysqli_query($db_link, $sql);



// Nachricht senden
	$empfaenger = utf8_decode($Vorname." ".$Nachname)." <".$Mail.">";

	// Die Nachricht
	$nachricht = '
	<html>
	<head>
	  <title>Best&auml;tigung der E-Mail-Adresse</title>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.$Vorname.',<br><br>
	  '.encode(str_ireplace("%userlink%", ' <a href="'.webadress.'/verify.php?u='.$id.'&v='.$verify.'">'.webadress.'/verify.php?u='.$id.'&v='.$verify.'</a>', $mail_verify)).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$Vorname.' '.$Nachname.' <br>
	  E-Mail: '.$Mail.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender;

	// Send
	$funzt = mail($empfaenger, '=?UTF-8?Q?Best=C3=A4tigung?= der E-Mail-Adresse', $nachricht, $header);
	//ä (ae): =C3=BC ; http://utf8-zeichentabelle.de/

