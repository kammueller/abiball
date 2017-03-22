<?php

include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../../home.php'); exit; }

include('../../back-end/db_captcha.php');

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

        $file = mysqli_real_escape_string($db_link, esc($_POST["datei"]));
        $file = "../../back-end/txt/pages/" . $file;
        if (!is_file($file)) {
            echo "Datei existiert nicht!";
            exit;
        }

        /** @var ARRAY|STRING $neuer_baustein
         * Ein Array mit den neuen Textbausteinen
         */
        $neuer_baustein = array();
        $i = 0;
        while (isset($_POST["textbaustein" . $i])) {
            $neuer_baustein[$i] = mysqli_real_escape_string($db_link, esc($_POST["textbaustein" . $i]));
            $i++;
        }

// Die Descriptions auslesen
        include($file);
        if (count($neuer_baustein) != count($descript)) {
            echo "<h1>Datei-Fehler!</h1><a href='bausteine.php'>Zurück</a> ";
            exit;
        }


        /** @var $handle
         * Die zu bearbeitete Datei zum Auslesen des Dokumenten-Startes
         */
        $handle = fopen($file, "r");

        $inhalt = fread($handle, filesize($file));
        /** @var STRING $starting
         * Die Dokumentation und der Beginn des PHP-Files
         */
        $starting = substr($inhalt, 0, strpos($inhalt, "### ### ###"));

        fclose($handle);

        /** @var $handle
         * Die zu bearbeitete Datei zum Schreiben des neuen Dokumentes
         */
        $handle = fopen($file, "w");
        fwrite($handle, $starting . "### ### ### \n\n\n"); // Dokumentation schreiben

        foreach ($neuer_baustein as $id => $baustein) { // Die Bausteine einfügen
            fwrite($handle, "\$descript[" . $id . "] = \"" . $descript[$id] . "\"; \n");
            fwrite($handle, "\$bausteine[" . $id . "] = \"" . $neuer_baustein[$id] . "\"; \n\n");
        }

        echo "<h1>Datei erfolgreich bearbeitet!</h1><a href='bausteine.php'>Zurück</a> ";
    }
    include ('../../back-end/design_gamma.inc.php');
} else {
    include ('../../back-end/design_alpha.inc.php');
    include ('../../back-end/design_beta.inc.php');
    echo "<h1>Passwort-Fehler!</h1><a href='bausteine.php'>Zurück</a> ";
    include ('../../back-end/design_gamma.inc.php');
}
