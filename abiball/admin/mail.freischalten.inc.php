<?php
/*
 * USER ZULASSEN - MAIL
 * Die Benachrichtigung an den nun freigeschalteten Nutzer
 * INC -> Muss Includiert werden! 
 */
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') OR ($zugriff =='verify') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

include('../back-end/txt/mail.php');

// User-ID abfragen
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$weg' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	$MailE = $result['Mail'];
	$VornameE = $result['Vorname'];
	$NachnameE = $result['Nachname'];

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
	  '.encode($mail_freischalten).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$VornameE.' '.$NachnameE.' <br>
	  E-Mail: '.$MailE.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender;

	// Send
	$funzt = mail($empfaenger, 'Dein Account wurde freigeschaltet', $nachricht, $header);

	if ($funzt){echo "Mail wurde versendet";}
	else {echo "Es ist jedoch zu einem internen Fehler gekommen. Bitte wende Dich an den Webmaster und gib die ID".$weg."an. Danke.";}

