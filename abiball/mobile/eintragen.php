﻿ <?php
 /*
  * @TODO Mailadresse auf .de o.ä. untersuchen!
  */
 include('../back-end/db_connect.inc.php');
 include('../back-end/db_escape.inc.php');
 include('../back-end/db_encode.inc.php');
 include('../back-end/txt/headerdata.php');
 include('../back-end/txt/pages/eintragen.php');
 header ('Content-type: text/html; charset=utf-8');
 $loggedIn = 0;


 if (!( isset($_POST["Vorname"]) && isset($_POST["Nachname"]) && isset($_POST["mail"]) && isset ($_POST["passwort"]) && isset ($_POST["passwort2"])) )
 {   $message = encode($bausteine[2]);
     /* include('eintragenNeu.php'); - NORMALFALL*/
     include('login.php');
     exit;}

$Vorname = mysqli_real_escape_string( $db_link, esc($_POST["Vorname"]) );
$Nachname = mysqli_real_escape_string( $db_link, esc($_POST["Nachname"]) );
$Mail = mysqli_real_escape_string( $db_link, esc($_POST["mail"]) );
$passwort = mysqli_real_escape_string( $db_link, esc($_POST["passwort"]));
$passwort2 = mysqli_real_escape_string( $db_link, esc($_POST["passwort2"]));


/* Alle Daten okay? */
 require_once('../admin/file-edit/recaptchalib.php'); #
 include ('../back-end/db_captcha.php');              #
 $privatekey = privatekey;                         #
 $resp = recaptcha_check_answer($privatekey,       #
     $_SERVER["REMOTE_ADDR"],                      # NUR FÜR EIGENBAU
     $_POST["recaptcha_challenge_field"],          #
     $_POST["recaptcha_response_field"]);          #
 #
 if (!$resp->is_valid) {                           #
     // What happens when the CAPTCHA was entered incorrectly
     $message = "Captcha-Code-Error!";             #
     include('login.php');                         #
     exit;                                         #
 }

 if( preg_match( '~[A-Z]~', $passwort) && // groß
     preg_match( '~[a-z]~', $passwort) && // klein
     preg_match( '~\d~', $passwort) && // ziffer
     (strlen( $passwort) > 7) ) {
     // gutes Passwort
 } else {
     $message = encode($bausteine[3]);
     /* include('eintragenNeu.php');  - NORMALFALL*/
     include('login.php');
     exit;
 }

 if (!preg_match("#^[a-zA-Z0-9@._-]+$#", $Mail)) {
     // Falsche Mailadresse
     $message = encode($bausteine[4]);
     /*include('eintragenNeu.php'); - NORMALFALL*/
     include('login.php');
     exit;
 }

 if($passwort == "" OR $Vorname == "" OR $Nachname == "" OR $Mail == "")
 {
     $message = $bausteine[2];
     /*include('eintragenNeu.php'); - NORMALFALL*/
     include('login.php');
     exit;
 }
 if ($passwort != $passwort2)
 {
     $message = encode($bausteine[5]);
     /*include('eintragenNeu.php');  - NORMALFALL*/
     include('login.php');
     exit; }

 /* NORMALFALL:
     if ($_POST['agb'] != true) {
         $message = encode($bausteine[6]);
             include('eintragenNeu.php');
         exit;
     }
 */

 /* Vorhandenheit prüfen & in Datenbank eintragen */
 $passwort = password_hash($passwort, PASSWORD_BCRYPT );

 /* $result = mysqli_query($db_link, "SELECT `id` FROM `abi_user` WHERE `Vorname` LIKE '$Vorname' AND `Nachname` LIKE '$Nachname'");
 $menge1 = mysqli_num_rows($result); - NORMALFALL */
 $menge1 = 0;

 $result = mysqli_query($db_link, "SELECT `id` FROM `abi_user` WHERE `Mail`= '$Mail'");
 $menge2 = mysqli_num_rows($result);

 $menge = $menge1 + $menge2;
	
	if($menge == 0) {
        /* $eintrag = "INSERT INTO `abi_user` (password, Vorname, Nachname, Mail, verified) VALUES ('$passwort', '$Vorname', '$Nachname', '$Mail', 'false')"; - NORMALFALL */
        $eintrag = "UPDATE `abiball`.`abi_user` SET `password` = '$passwort', `verified` = 'false', `Mail` = '$Mail' WHERE `Vorname` = '$Vorname' AND `Nachname` = '$Nachname';";
        $eintragSQL = mysqli_query($db_link, $eintrag);

        if ($eintragSQL == true) {
            $out = "Der Benutzer <b>" . utf8_decode($Vorname . " " . $Nachname) . "</b> wurde erstellt.<br>";
            include('verify_mail.inc.php');
            echo('
				<!doctype html>
				<html>
				<head>
					
					<title>' . html_title . '</title>
					<link rel="stylesheet" type="text/css" href="/back-end/fonts/fonts.css">
					<link rel="stylesheet" type="text/css" href="/mobile/design.css">
					
					
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
					<meta name="author" content="Matthias Kamm�ller">
					<meta name="description" content="Herzlich Willkommen auf der Website zum Abiball 2015.
					Ohne Account wirst du hier nichts machen k�nnen.">
					<meta name="keywords" content="Abiball, LMGU, Unterhaching, Karten">
					
					<meta name=viewport content="width=device-width, initial-scale=1">
					
					<!-- JQuery -->	
					<script src="/back-end/jquery.js"></script>
					<!-- Auf Aufl�sung �berpr�fen, DIVS positionieren, �nderungen �berwachen -->
					<script src="/mobile/design.js"></script>
					
				</head>


				<body>

				<!-- HEADER -->
					<img src="/img/mobileHeader.PNG" id="header" height="100%" width="auto">
					
					<div id="menueHeader"> &nbsp;
					</div>
					

				<!-- CONTENT -->
					
					<div class="out" id="message">
						' . $out . '
					</div>
					
				</body>
				</html> ');
        } else
            {
                $message = encode($bausteine[7]);
                /*include ('eintragenNeu.php'); - Normalfall */
                include('login.php');
            }
        } else {
            if ($menge1 == 0) {
                $message = encode($bausteine[8]);
                include('login.php');
            } else {
                $message = encode($bausteine[9]);
                include('login.php');
            }
        }
