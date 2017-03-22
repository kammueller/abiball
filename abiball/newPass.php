<?php

include('back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

include('back-end/txt/pages/profil.php');
include('back-end/txt/mail.php');

$passwort = mysqli_real_escape_string( $db_link, esc($_POST['newPass1'] ) );
$passwort2 = mysqli_real_escape_string( $db_link, esc($_POST['newPass2'] ) );
$passwortAlt = mysqli_real_escape_string( $db_link, esc($_POST['oldPass'] ) );

// Passw�rter checken
	if( preg_match( '~[A-Z]~', $passwort) &&
		preg_match( '~[a-z]~', $passwort) &&
		preg_match( '~\d~', $passwort) &&
		(strlen( $passwort) > 7) ) {
		// gutes Passwort
	} else {
        include ('back-end/design_alpha.inc.php');
        include ('back-end/design_beta.inc.php');
        echo encode($bausteine[5]); // unsicheres PW
        include ('back-end/design_gamma.inc.php');
		exit;
	}
	if ($passwort != $passwort2)
	{
        include ('back-end/design_alpha.inc.php');
        include ('back-end/design_beta.inc.php');
        echo encode($bausteine[6]); // PW nicht identisch
        include ('back-end/design_gamma.inc.php');
	exit; }
	
// Speichern
	$passwort = password_hash($passwort, PASSWORD_BCRYPT );
	
	// stimmt das bisherige Passwort?
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$user_id' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$datensatz = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	if( password_verify($passwortAlt, $datensatz['password']) ) {
		$sql = "UPDATE `abi_user` SET `password` = '$passwort' WHERE `id` = '$user_id'";
		$db_erg = mysqli_query($db_link, $sql);
		// Logout
		setcookie("US", "delete", time()-600, "/");
		setcookie("ID", "delete", time()-600, "/");
		$sql = "DELETE FROM `abi_session` WHERE `user_id` = '$user_id'";
		$db_erg = mysqli_query($db_link, $sql);
		$out =  "Passwort wurde ge&auml;ndert.";
		include('login.php');
		
		// Per Mail informieren
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
			  '.encode($mail_newpass).'<br><br>
			  Von Dir angegebene Daten:<br>
			  Name: '.$Vorname.' '.$Nachname.' <br>
			  E-Mail: '.$Mail.' <br>
			</body>';

			//Infos
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
            $header .= 'From: '.$absender;

			// Send
			$funzt = mail($empfaenger, '=?UTF-8?Q?=c3=84nderung?= des Passwortes', $nachricht, $header);

			if ($funzt){
				// weitermachen
			} else {
				include('back-end/design_alpha.inc.php');
				include ('back-end/design_beta.inc.php');
				echo encode($error_mail);
				include ('back-end/design_gamma.inc.php');
				exit;
            }
				
	} else {
		
		setcookie("US", "delete", time()-600, "/");
		setcookie("ID", "delete", time()-600, "/");
		$sql = "DELETE FROM `abi_session` WHERE `user_id` = '$user_id'";
		$db_erg = mysqli_query($db_link, $sql);
		$message = encode($bausteine[7]); // falsches altes PW
		include('login.php');}
