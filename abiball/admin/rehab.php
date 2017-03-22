<?php
/*
 * BLOCKADE AUFHEBEN
 * Einen User wieder zulassen
 * Speichert in der Datenbank und informiert per Mail
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

include('../back-end/txt/mail.php');

// Zu erledigende Arbeit
	// Daten Sammeln
	$rehab = mysqli_real_escape_string( $db_link, esc($_GET["id"]));
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$rehab' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	$MailE = $result['Mail'];
	$VornameE = utf8_decode($result['Vorname']);
	$NachnameE = utf8_decode($result['Nachname']);
// wurde das bereits ausgef�hrt?
	if ($result['verified'] == "true") { $error = "Der User wurde bereits rehabilitiert."; include('index.inc.php'); exit; }
	// In der Datenbank freischalten
	$sql1 = mysqli_query($db_link, "UPDATE `abi_user` SET `verified` = 'true' WHERE `id` = '$rehab'");
	$db_erg1 = mysqli_query($db_link, $sql1);
	// Begr�ndung l�schen
	$sql = mysqli_query($db_link, "DELETE FROM `abi_blocked` WHERE `user_id` = '$rehab'");
	$db_erg = mysqli_query($db_link, $sql);
		
		
// Nachricht senden
	$empfaenger = $VornameE." ".$NachnameE." <".$MailE.">";
	
	// Die Nachricht
	$nachricht = '
	<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.$VornameE.',<br><br>
	  '.encode($mail_rehab).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$VornameE.' '.$NachnameE.' <br>
	  E-Mail: '.$MailE.' <br>
	</body>
	</html>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $header .= 'From: '.$absender;

	// Send
	$funzt = mail($empfaenger, 'Dein Account wieder freigeschaltet', $nachricht, $header);

	if ($funzt){$success = "Mail wurde versendet";}
	else {$error = "Es ist zu einem internen Fehler gekommen. Bitte wende Dich an den Webmaster und gib die ID ".$rehab." an. Danke.";}
	include('index.inc.php');
	echo "test";
