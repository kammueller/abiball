<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

include('../back-end/txt/mail.php');

if (!(isset($_POST["newMail"]) && isset($_POST["user"]))) {
    $error = "Nicht genügend Daten angegeben!";
    include('index.inc.php'); exit;
}

$MailNeu = mysqli_real_escape_string( $db_link, esc($_POST['newMail']));
$id = mysqli_real_escape_string( $db_link, esc($_POST['user']));

// User-Daten ziehen
	$sql = mysqli_query($db_link, "SELECT * FROM `abi_user` WHERE `id` = '$id'");
	$datensatz = mysqli_fetch_array($sql, MYSQL_ASSOC);
	$VornameE = $datensatz['Vorname'];
	$NachnameE = $datensatz['Nachname'];
	$MailE = $datensatz['Mail'];
	
	// ist der Nutzer blockiert?
	if ($datensatz['verified'] == "geblockt") {
		$error = "Nutzer ist blockiert!"; 
		include ('index.inc.php');
	}
	// schon mal ausgeführt?
	if ( $MailE == $MailNeu ) { $error = "Dieser Vorgang wurde bereits ausgef&uuml;hrt."; include ('index.inc.php'); exit; }
	// richtige Mailadresse? /*@TODO verbessern */
	if (!preg_match("#^[a-zA-Z0-9@._-]+$#", $MailNeu)) { $error = "Inkorrekte Mailadresse!<br>ggf. Punycode verwenden!";	include('index.inc.php'); exit; }
	
	// ggf. bestehenden Hash löschen
	$db_erg = mysqli_query($db_link, "DELETE FROM `abi_verify` WHERE `user_id` = '$id';");

	
// Alte Mail-Adresse informieren
	$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";

	// Die Nachricht
	$nachricht = '
	<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.$VornameE.',<br><br>
	  '.encode($mail_newmail_old_admin).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$VornameE.' '.$NachnameE.' <br>
	  (bisherige) E-Mail: '.$MailE.' <br>
	  (neue) E-Mail: '.$MailNeu.' <br>
	</body>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender;

	// Send
	$funzt = mail($empfaenger, '=?UTF-8?Q?=c3=84nderung?= der E-Mail-Adresse', $nachricht, $header);

	if ($funzt){
		echo "jo"; // weitermachen
	} else {
		$error = "Es ist zu einem internen Fehler gekommen. Bitte versuche es erneut."; 
		include ('index.inc.php');
		exit;}


// User einschränken
	$sql = "UPDATE `abi_user` SET `verified` = 'newMail', `Mail` = '$MailNeu' WHERE `id` = '$id'";
	$db_erg = mysqli_query($db_link, $sql);
// Verifizierungslink erstellen
	$verify = md5(rand(999, 999999));
	$sql = "INSERT INTO `abi_verify` (`user_id`, `hash`) VALUES ('$id', '$verify')";
	$db_erg = mysqli_query($db_link, $sql);


// Nachricht senden
	$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailNeu.">";

	// Die Nachricht
    $nachricht = '
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=utf-8">
        </head>
        <body>
          Hallo '.$VornameE.',<br><br>
          '.encode(str_ireplace("%userlink%", '<a href="'.webadress.'/verify.php?u='.$id.'&v='.$verify.'&z=neu">'.webadress.'/verify.php?u='.$id.'&v='.$verify.'&z=neu</a>', $mail_newmail_new_admin)).'<br><br>
          Von Dir angegebene Daten:<br>
          Name: '.$VornameE.' '.$NachnameE.' <br>
          (bisherige) E-Mail: '.$MailE.' <br>
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
		$success = "Die E-Mail-Adresse wurde aktualisiert.";
		include ('index.inc.php');
	} else {
		$error = "Es ist zu einem internen Fehler gekommen. Bitte versuche es erneut."; 
		include ('index.inc.php');}
