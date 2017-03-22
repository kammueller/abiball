<?php

include('back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('login.php'); exit; }

$MailNeu = mysqli_real_escape_string( $db_link, esc($_POST['newMail'] ) );
include('back-end/txt/pages/profil.php');
include('back-end/txt/mail.php');

//Korrekte Mailadresse?
	if (!preg_match("#^[a-zA-Z0-9@._-]+$#", $MailNeu)) {
		include('back-end/design_alpha.inc.php');
		include ('back-end/design_beta.inc.php');
		echo encode($bausteine[3]);
		include ('back-end/design_gamma.inc.php');
		exit; }

// Alte Mail-Adresse informieren
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
	  '.encode($mail_newmail_old).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$Vorname.' '.$Nachname.' <br>
	  (bisherige) E-Mail: '.$Mail.' <br>
	  (neue) E-Mail: '.$MailNeu.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.header.' <'.admin_mail.'>' . "\r\n";

	// Send
	$funzt = mail($empfaenger, '=?UTF-8?Q?=c3=84nderung?= der E-Mail-Adresse', $nachricht, $header);

	if ($funzt){
		// weitermachen
	} else {
		include('back-end/design_alpha.inc.php');
		include ('back-end/design_beta.inc.php');
		echo encode($error_mail);
		include ('back-end/design_gamma.inc.php');
		exit;
    }


// User einschränken
	$sql = "UPDATE `abi_user` SET `verified` = 'newMail', `Mail` = '$MailNeu' WHERE `id` = '$user_id'";
	$db_erg = mysqli_query($db_link, $sql);
// Verifizierungslink erstellen
	$verify = md5(rand(999, 999999));
	$sql = "INSERT INTO `abi_verify` (`user_id`, `hash`) VALUES ('$user_id', '$verify')";
	$db_erg = mysqli_query($db_link, $sql);


// Nachricht senden
	$empfaenger = utf8_decode($Vorname." ".$Nachname)." <".$MailNeu.">";

	// Die Nachricht
	$nachricht = '
	<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.$Vorname.',<br><br>
	  '.encode(str_ireplace("%userlink%", '<a href="'.webadress.'/verify.php?u='.$user_id.'&v='.$verify.'&z=neu">'.webadress.'/verify.php?u='.$user_id.'&v='.$verify.'&z=neu</a>', $mail_newmail_new)).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$Vorname.' '.$Nachname.' <br>
	  (bisherige) E-Mail: '.$Mail.' <br>
	  (neue) E-Mail: '.$MailNeu.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender;

	// Send
	$funzt = mail($empfaenger, '=?UTF-8?Q?Best=C3=A4tigung?= der E-Mail-Adresse', $nachricht, $header);
	//�: =C3=BC ; http://utf8-zeichentabelle.de/

	if ($funzt){
		setcookie("US", "delete", time()-600, "/");
		setcookie("ID", "delete", time()-600, "/");
		$sql = "DELETE FROM `abi_session` WHERE `user_id` = '$user_id'";
		$db_erg = mysqli_query($db_link, $sql);
		$message = encode($bausteine[4]);
		include ('login.php');
	} else {
		include('back-end/design_alpha.inc.php');
		include ('back-end/design_beta.inc.php');
		echo encode($error_mail);
		include ('back-end/design_gamma.inc.php');}
