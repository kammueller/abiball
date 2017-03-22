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

        if(!(isset($_POST["db"]) && isset($_POST["login"]) && isset($_POST["session"]) && isset($_POST["cookie"]) && isset($_POST["pw"]) && isset($_POST["mail"]))) {
            echo "Nicht genügend Daten angegeben";
            include ('../../back-end/design_gamma.inc.php');
            exit;
        }


        $file = "../../back-end/txt/errors.php";

        $db = mysqli_real_escape_string($db_link, esc($_POST["db"]));
        $login = mysqli_real_escape_string($db_link, esc($_POST["login"]));
        $session = mysqli_real_escape_string($db_link, esc($_POST["session"]));
        $cookie = mysqli_real_escape_string($db_link, esc($_POST["cookie"]));
        $pw = mysqli_real_escape_string($db_link, esc($_POST["pw"]));
        $mail = mysqli_real_escape_string($db_link, esc($_POST["mail"]));

        $content = '<?php
/**
 * FEHLERMELDUNGEN
 * definiert die verschienden Fehler
 */

/** @var STRING $error_db
 * wenn keine Datenbank-Verbindung besteht
 */
$error_db = "'.$db.'";

/** @var STRING $error_login
 * wenn man nicht (mehr) angemeldet ist
 */
$error_login = "'.$login.'";

/** @var STRING $error_session
 * falls kein Login erstellt werden kann
 */
$error_session = "'.$session.'";

/** @var STRING $error_cookie
 * falls keine Cookies gesetzt werden können
 */
$error_cookie = "'.$cookie.'";

/** @var STRING $error_pw
 * falsche Benutzer/Passwort-Kombination
 */
$error_pw = "'.$pw.'";

/** @var STRING $error_mail
 * Falls eine Mail nicht versendet werden konnte
 */
$error_mail = "'.$mail.'";
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
