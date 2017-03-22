<?php
/*
 * ADMIN ERNENNEN - MAIL
 * Die Benachrichtigung an den neuen Admin
 * INC -> Muss Includiert werden! 
 */
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

include ('../back-end/txt/mail.php');

// User-ID abfragen
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$neu' LIMIT 1";
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
	  <title>Upgrade des Accounts</title>
	   <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.$VornameE.',<br><br>
      '.encode($mail_newadmin).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$VornameE.' '.$NachnameE.' <br>
	  E-Mail: '.$MailE.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender . "\r\n" .
        'Bcc: '.admin_mail;

	// Send
	$funzt = mail($empfaenger, 'Du wurdest zum Administrator ernannt!', $nachricht, $header);

