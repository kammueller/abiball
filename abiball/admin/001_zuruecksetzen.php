<?php
include('../back-end/logincheck.inc.php');
header('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) {
    $message = encode($error_login);
    include('../login.php');
    exit;
}
if ($loggedIn != "speak Friend and Enter") {
    $message = encode($error_login);
    include('../login.php');
    exit;
}
if (!isset($zugriff)) {
    header('location: ../home.php');
    exit;
}
if ($zugriff != 'all') {
    header('location: ../home.php');
    exit;
}
include('../back-end/txt/mail.php');

include("../back-end/db_captcha.php");
require_once('file-edit/recaptchalib.php');
$privatekey = privatekey;
$resp = recaptcha_check_answer($privatekey,
    $_SERVER["REMOTE_ADDR"],
    $_POST["recaptcha_challenge_field"],
    $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    echo "<h1>Captcha-Fehler!</h1><a href='000_zuruecksetzen.php'>Zurück</a> ";
    exit;
}

// stimmt das Passwort? 
$adminPW = mysqli_real_escape_string($db_link, esc($_POST["adminPW"]));
/* @todo PW anpassen */
if (password_verify($adminPW, '$2y$10$QSNghM4VUJzRi.dYRP5FeOyzbnL3oB6M0Q2qRAMVAorh0YUC2qkE. ')) {
    // Alle User per Mail informieren
    $db_erg = mysqli_query($db_link, "SELECT * FROM `abi_user`;");
    while ($datensatz = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
        $VornameE = $datensatz['Vorname'];
        $NachnameE = $datensatz['Nachname'];
        $MailE = $datensatz['Mail'];

        $empfaenger = utf8_decode($VornameE . " " . $NachnameE) . " <" . $MailE . ">";

        // Die Nachricht
        $nachricht = '
		<html>
		<head>
		  <title>Website wurde zur&uuml;ckgesetzt</title>
		  <meta http-equiv="content-type" content="text/html; charset=utf-8">
		</head>
		<body>
		  Hallo ' . $VornameE . ',<br><br>
		  ' . encode($mail_reset) . '
		</body>';

        //Infos
        $header = 'MIME-Version: 1.0' . "\r\n";
        $header .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $header .= 'From: ' . header . ' <' . admin_mail . '>' . "\r\n";

        // Send
        $funzt = mail($empfaenger, '=?UTF-8?Q?Zur=C3=BCcksetzung?= der Website', $nachricht, $header);

        if ($funzt) {
            echo "Mail an User-ID " . $datensatz['id'] . " wurde versendet <br>"; // weitermachen
            $endcheck = True;
        } else {
            $error = "Es ist zu einem internen Fehler gekommen. Bitte versuche es erneut. <br>";
            $endcheck = False;
            exit;
        }

    }
    if ($endcheck) {
        // Alles Leeren
        $sql = "TRUNCATE `abi_0_kartenfreischalt`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_admin`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_bestellung`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_blocked`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_karten`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_news`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_reservierung`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_session`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_user`;";
        mysqli_query($db_link, $sql);
        $sql = "TRUNCATE `abi_verify`;";
        mysqli_query($db_link, $sql);

        // Admin anlegen
        $sql = "INSERT INTO `abi_admin` (`user_id`, `rechte`) VALUES ('1', 'all');";
        mysqli_query($db_link, $sql);
        // Nutzer anlegen
        $Vorname = mysqli_real_escape_string($db_link, esc($_POST["Vorname"]));
        $Nachname = mysqli_real_escape_string($db_link, esc($_POST["Nachname"]));
        $Mail = mysqli_real_escape_string($db_link, esc($_POST["mail"]));
        $passwort = mysqli_real_escape_string($db_link, esc($_POST["passwort"]));
        $passwort = password_hash($passwort, PASSWORD_BCRYPT);
        $eintrag = "INSERT INTO `abi_user` (id, password, Vorname, Nachname, Mail, verified) VALUES ('1', '$passwort', '$Vorname', '$Nachname', '$Mail', 'true')";
        $eintragen = mysqli_query($db_link, $eintrag);
        // Karten freigeben
        $sql = "INSERT INTO `abi_0_kartenfreischalt` (`timestamp`, `anzahl`, `uebrig`, `reserviert`) VALUES ('100', '0', '20', '0');";
        mysqli_query($db_link, $sql);
        echo "<br><br>Erfolgreich Website zur&uuml;ckgesetzt";
    }

} else {
    echo "Falsches Passwort!";
}
