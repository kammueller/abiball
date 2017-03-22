<?php
/*
 * ZAHLUNG REGISTRIEREN
 * Fragt Zahlungsdetails ab, leitet zu mail.zahlungerhalten weiter
 */
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if (!( ($zugriff == 'all') OR ($zugriff == 'finance') )) { header('location: ../home.php'); exit; }

if(!isset($_POST["nr"])) {
    header("location: index.php"); exit;
}

include('../back-end/txt/mail.php');

$Nummer = mysqli_real_escape_string( $db_link, esc($_POST['nr']));
$sql = mysqli_query($db_link, "SELECT * FROM `abi_bestellung` WHERE `BestellNr` = '$Nummer'");
$datensatz = mysqli_fetch_array($sql, MYSQL_ASSOC);
if(!isset($datensatz)) { //keine gültige Nummer
    header("location: index.php"); exit;
}
$id = $datensatz['user_id'];
$datum_raw = $datensatz['datum'];
$mahnung = $datensatz['mahnung'];

// Darf gemahnt werden? (14 Tage unbezahlt / 7 Tage seit letzter Mahnung)
$access = false;
if (isset($mahnung)) {
    // Vor 7 Tagen das letzte Mal gemahnt?
    $mahnung1 = strtotime( $mahnung );
    $early_mahn = $mahnung1 + 60*60*24*7;  // fr�hestes Blockierdatum
    if ( mktime() > $early_mahn ) {
        $access = true;
    }
} else {
    $mahnung = strtotime( $datum_raw );
    $early_mahn = $mahnung + 60*60*24*14;
    if ( mktime() > $early_mahn ) {
        $access = true;
    }
}

if ($access) {
    $sql = "SELECT * FROM `abi_user` WHERE `id` = '$id' LIMIT 1";
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
	  '.encode(str_ireplace("%RechnungsNummer%", $Nummer, $mail_mahnung)).'<br><br>
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
    $funzt = mail($empfaenger, 'Zahlungserinnerung', $nachricht, $header);

    if ($funzt) {
        $success = "Mail wurde versendet";
        // In Datenbank einspeichern
        $date = date("Y-m-d");
        $sql = mysqli_query($db_link, "UPDATE `abi_bestellung` SET `mahnung` = '".date("y-m-d", time())."' WHERE `BestellNr` = '$Nummer';");
        $db_erg = mysqli_query($db_link, $sql);
    } else {$error = "Mail konnte aus unbekannten Gründen nicht versendet werden.";}
} else {
    $error = "Nutzer darf nicht gemahnt werden!";
}

include('index.inc.php');