<?php
/*
 * USER BLOCKIEREN
 * Zugangsrechte eines Users löschen
 * Blockt und versendet die Mail
 */
 
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'announce') OR ($zugriff =='verify') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

include('../back-end/txt/mail.php');

// Zu erledigende Arbeit
if(!(isset($_POST["id"]) && isset($_POST["begruendung"]))){
    $error = "nicht alle Daten übergeben!";
    include('index.inc.php'); exit;
}
	// Daten Sammeln
	$weg = mysqli_real_escape_string( $db_link, esc($_POST["id"]));
	$begr = mysqli_real_escape_string( $db_link, esc($_POST['begruendung']));
// Ist die Begründung vorhanden?
if ( ($begr == "Bitte hier Begründung angeben! Kopie wird an Webmaster verschickt.") || ($begr == "") ) {
	$error = "Fehler:<br>Keine Begründung angegeben."; include('index.inc.php'); exit;
} else {
    if ($begr == "Fake E-Mail-Adresse") {
        // E-Mail-Adresse ändern
        include ("../back-end/txt/headerdata.php");
        mysqli_query($db_link, "UPDATE `abi_user` SET `mail` = '".admin_mail."' WHERE `id` = '$weg'");
    }
	$sql = "SELECT * FROM `abi_user` WHERE `id` = '$weg' LIMIT 1";
	$db_erg = mysqli_query($db_link, $sql);
	$result = mysqli_fetch_array($db_erg, MYSQL_ASSOC);	
	$MailE = $result['Mail'];
	$VornameE = $result['Vorname'];
	$NachnameE = $result['Nachname'];
	
// Ist der User schon geblockt?
	if ( $result['verified'] == "geblockt" ) {
		$error = "Der Benutzer wurde bereits geblockt.";
		include('index.inc.php'); exit;
	}

// Soll ein Admin geblockt werden? (unmöglich)
    $sql = "SELECT * FROM `abi_admin` WHERE `user_id` = '$weg' LIMIT 1";
    $db_erg = mysqli_query($db_link, $sql);
    if( ($menge = mysqli_num_rows($db_erg)) != 0 ) {
        $error = "Administratoren können nicht geblockt werden!";
        include ('index.inc.php'); exit; }
	
	// Blockieren in der Datenbank	
	$sql1 = mysqli_query($db_link, "UPDATE `abi_user` SET `verified` = 'geblockt' WHERE `id` = '$weg'");
	$db_erg1 = mysqli_query($db_link, $sql1);
	// ggf. Hash-Eintrag (Mail-Verifizierung) löschen
	$sql = "DELETE FROM `abi_verify` WHERE `user_id` = '$weg'";
	$db_erg = mysqli_query($db_link, $sql);
	// Begründung speichern
	$admin = $user_id;
	$date = date("Y-m-d");
	$sql = mysqli_query($db_link, "INSERT INTO `abi_blocked` (`user_id`, `admin_id`, `Grund`, `datum`) VALUES ('$weg', '$admin', '$begr', '$date' )");
	$db_erg = mysqli_query($db_link, $sql);
	
	
	
// Nachricht senden
	$empfaenger = utf8_decode($VornameE." ".$NachnameE)." <".$MailE.">";
	//echo $empfaenger;
	

	// Die Nachricht
	$nachricht = '
	<html>
	<head>
	  <meta http-equiv="content-type" content="text/html; charset=utf-8">
	</head>
	<body>
	  Hallo '.$VornameE.',<br><br>
      '.encode(str_ireplace("%Begründung%", $begr, $mail_blockieren)).'<br><br>
	  Von Dir angegebene Daten:<br>
	  Name: '.$VornameE.' '.$NachnameE.' <br>
	  E-Mail: '.$MailE.' <br>
	</body>
	</html>';

	//Infos
	$header  = 'MIME-Version: 1.0' . "\r\n";
	$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $header .= 'From: '.$absender . "\r\n" .
        'Bcc: '.admin_mail;
		
		

	// Send
	$funzt = mail($empfaenger, 'Dein Account wurde gesperrt', $nachricht, $header);

	
	if ($funzt){$success = "Mail wurde versendet<br>";}
	else {$error = "Es ist zu einem internen Fehler gekommen. Bitte wende Dich an den Webmaster und gib die ID ".$weg." an. Danke.";}
	include('index.inc.php');
}
