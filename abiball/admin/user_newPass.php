<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

include ('../back-end/txt/mail.php');

$passwort_clear = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);
$id = mysqli_real_escape_string( $db_link, esc($_POST['user']));

// User-Daten ziehen
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
	$datensatz = mysqli_fetch_array($sql, MYSQLI_ASSOC);
	$VornameE = $datensatz['Vorname'];
	$NachnameE = $datensatz['Nachname'];
	$MailE = $datensatz['Mail'];

	
// Speichern
	$passwort = password_hash($passwort_clear, PASSWORD_BCRYPT );
	
	$sql = "UPDATE `abi_user` SET `password` = '$passwort' WHERE `id` = '$id'";
	$db_erg = mysqli_query($db_link, $sql);
	
	// Per Mail informieren
		$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";

		// Die Nachricht
		$nachricht = '
		<html>
		<head>
		  <meta http-equiv="content-type" content="text/html; charset=utf-8">
		</head>
		<body>
		  Hallo '.$VornameE.',<br><br>
		  '.encode(str_ireplace("%GeneriertesPasswort%", $passwort_clear, $mail_newpass_admin)).'<br><br>
		  Von Dir angegebene Daten:<br>
		  Name: '.$VornameE.' '.$NachnameE.' <br>
		  E-Mail: '.$MailE.' <br>
		</body>';

		//Infos
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $header .= 'From: '.$absender;

		// Send
		$funzt = mail($empfaenger, '=?UTF-8?Q?=c3=84nderung?= des Passwortes', $nachricht, $header);

		if ($funzt){
			$success = "Das Passwort wurde aktualisiert.<br>
			Achtung: Neu laden ändert es erneut!";
			include ('index.inc.php');
		} else {
			$error = "Es ist zu einem internen Fehler gekommen. Bitte versuche es erneut."; 
			include ('index.inc.php');
			exit;}

