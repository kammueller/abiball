<?php

include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../../home.php'); exit; }

include('../../back-end/db_captcha.php');
if (!isset($_POST["pass"])) {
    include ('../../back-end/design_alpha.inc.php');
    include ('../../back-end/design_beta.inc.php');
    echo "<h1>Passwort-Fehler!</h1><a href='bausteine.php'>Zurück</a> ";
    include ('../../back-end/design_gamma.inc.php');
    exit;
}

$adminPW = mysqli_real_escape_string( $db_link, esc($_POST["pass"]) );
if ( password_verify($adminPW, check) ) {

// CAPTCHA
    require_once('recaptchalib.php');
    $privatekey = privatekey;
    $resp = recaptcha_check_answer($privatekey,
        $_SERVER["REMOTE_ADDR"],
        $_POST["recaptcha_challenge_field"],
        $_POST["recaptcha_response_field"]);


    if (!$resp->is_valid) {
        // What happens when the CAPTCHA was entered incorrectly
        include('../../back-end/design_alpha.inc.php');
        include ('../../back-end/design_beta.inc.php');
        echo "<h1>Captcha-Fehler!</h1><a href='bausteine.php'>Zurück</a> ";
        include('../../back-end/design_gamma.inc.php');
        exit;
    } else {
        include('../../back-end/design_alpha.inc.php');
        include ('../../back-end/design_beta.inc.php');

        if(!(isset($_POST["i_res"]) && isset($_POST["i_erste"]) && isset($_POST["i_nach"]) && isset($_POST["i_tausch"]) && isset($_POST["bestell"]))) {
            echo "Nicht genügend Daten angegeben";
            include ('../../back-end/design_gamma.inc.php');
            exit;
        }


        $file = "../../back-end/txt/karten_links.php";

        $i_res = mysqli_real_escape_string($db_link, esc($_POST["i_res"]));
        $i_erste = mysqli_real_escape_string($db_link, esc($_POST["i_erste"]));
        $i_nach = mysqli_real_escape_string($db_link, esc($_POST["i_nach"]));
        $i_tausch = mysqli_real_escape_string($db_link, esc($_POST["i_tausch"]));
        $bestell = mysqli_real_escape_string($db_link, esc($_POST["bestell"]));

        $alleDatenda = false;
        if(!strpos($i_res, "%link*%nachbestellen%")) {
            $alleDatenda = true;
        } elseif (!strpos($i_erste, "%link*%bestellen%")) {
            $alleDatenda = true;
        } elseif (!strpos($i_nach, "%link*%nachbestellen%")) {
            $alleDatenda = true;
        } elseif (!strpos($i_tausch, "%link*%tauschen%")) {
            $alleDatenda = true;
        } elseif (!strpos($bestell, "%link*%rechnungen%")) {
            $alleDatenda = true;
        }
        if ($alleDatenda) {
            echo "<h1>Notwendige Bausteine wurden nicht verwendet!</h1>";
            include ('../../back-end/design_gamma.inc.php');
            exit;
        }

        $content = '<?php
/**
 * Karten Links
 * Die Beschreibungen mit Links innerhalb der Kartenbestellung
 * @TODO bearbeitung bauen
 */

/** @var STRING $karten_index_reserviert
 * Wenn man gerade Karten reserviert hat,
 * %link*%nachbestellen% muss vorhanden sein
 */
$karten_index_reserviert = "'.$i_res.'";

/** @var STRING $karten_index_ersterunde
 * Erste Bestellrunde - Karten bestellen
 * %link*%bestellen% muss vorhanden sein
 */
$karten_index_ersterunde = "'.$i_erste.'";

/** @var STRING $karten_index_nachbestellen
 * Nachbetstellung - Karten sichern
 * %link*%nachbestellen% muss vorhanden sein
 */
$karten_index_nachbestellen = "'.$i_nach.'";

/** @var STRING $karten_index_tauschen
 * Karten tauschen
 * %link*%tauschen% muss vorhanden sein
 */
$karten_index_tauschen = "'.$i_tausch.'";

/** @var STRING $karten_bestellung_rechnung
 * Bestellung wurde abgearbeitet, Downloadlink etc
 * %RechnungsNummer% ist verwendbar,
 * %link*%rechnungen% muss verwendet werden!
 */
$karten_bestellung_rechnung = "'.$bestell.'";
                ';


        /** @var $handle
         * Die zu bearbeitete Datei zum Schreiben des neuen Dokumentes
         */
        $handle = fopen($file, "w");
        fwrite($handle, $content);


        echo "<h1>Datei erfolgreich bearbeitet!</h1><a href='bausteine.php'>Zurück</a> ";
    }
    include ('../../back-end/design_gamma.inc.php');
} else {
    include ('../../back-end/design_alpha.inc.php');
    include ('../../back-end/design_beta.inc.php');
    echo "<h1>Passwort-Fehler!</h1><a href='bausteine.php'>Zurück</a> ";
    include ('../../back-end/design_gamma.inc.php');
}
