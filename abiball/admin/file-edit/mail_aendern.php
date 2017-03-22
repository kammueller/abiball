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

        if(!(isset($_POST["nmo"]) && isset($_POST["nmn"]) && isset($_POST["nmoa"]) && isset($_POST["nmna"]) && isset($_POST["np"]) && isset($_POST["npa"])
        && isset($_POST["v"]) && isset($_POST["f"]) && isset($_POST["b"]) && isset($_POST["r"]) && isset($_POST["a"]) && isset($_POST["new"]) && isset($_POST["no"])
            && isset($_POST["kr"]) && isset($_POST["zd"]) && isset($_POST["kt"]) && isset($_POST["kw"]) && isset($_POST["zw"]) && isset($_POST["reset"]) )) {
            echo "Nicht genügend Daten angegeben";
            include ('../../back-end/design_gamma.inc.php');
            exit;
        }


        $file = "../../back-end/txt/mail.php";

        $nmo = mysqli_real_escape_string($db_link, esc($_POST["nmo"]));
        $nmn = mysqli_real_escape_string($db_link, esc($_POST["nmn"]));
        $nmoa = mysqli_real_escape_string($db_link, esc($_POST["nmoa"]));
        $nmna = mysqli_real_escape_string($db_link, esc($_POST["nmna"]));
        $np = mysqli_real_escape_string($db_link, esc($_POST["np"]));
        $npa = mysqli_real_escape_string($db_link, esc($_POST["npa"]));
        $v = mysqli_real_escape_string($db_link, esc($_POST["v"]));
        $f = mysqli_real_escape_string($db_link, esc($_POST["f"]));
        $b = mysqli_real_escape_string($db_link, esc($_POST["b"]));
        $r = mysqli_real_escape_string($db_link, esc($_POST["r"]));
        $a = mysqli_real_escape_string($db_link, esc($_POST["a"]));
        $new = mysqli_real_escape_string($db_link, esc($_POST["new"]));
        $no = mysqli_real_escape_string($db_link, esc($_POST["no"]));
        $kr = mysqli_real_escape_string($db_link, esc($_POST["kr"]));
        $zd = mysqli_real_escape_string($db_link, esc($_POST["zd"]));
        $kt = mysqli_real_escape_string($db_link, esc($_POST["kt"]));
        $kw = mysqli_real_escape_string($db_link, esc($_POST["kw"]));
        $zw = mysqli_real_escape_string($db_link, esc($_POST["zw"]));
        $mm = mysqli_real_escape_string($db_link, esc($_POST["mm"]));
        $reset = mysqli_real_escape_string($db_link, esc($_POST["reset"]));


        $alleDatenda = false;
        /* check auf Vorkommen benötigter Textbausteine */
        if(!strpos($nmn, "%userlink%")) {
            $alleDatenda = true;
        } elseif (!strpos($nmna, "%userlink%")) {
            $alleDatenda = true;
        } elseif (!strpos($npa, "%GeneriertesPasswort%")) {
            $alleDatenda = true;
        } elseif (!strpos($v, "%userlink%")) {
            $alleDatenda = true;
        } elseif (!strpos($b, "%Begründung%")) {
            $alleDatenda = true;
        } elseif (!strpos($kt, "%KartenID%")) {
            $alleDatenda = true;
        } elseif (!strpos($kt, "%NeuerInhaber%")) {
            $alleDatenda = true;
        } elseif (!strpos($zw, "%Begründung%")) {
            $alleDatenda = true;
        }
        if ($alleDatenda) {
            echo "<h1>Notwendige Bausteine wurden nicht verwendet!</h1>";
            include ('../../back-end/design_gamma.inc.php');
            exit;
        }

        $content = '<?php
/**
 * MAIL
 * Die verschiedenen Mail-Texte
 * beginnend mit "Hallo [Vorname], ...", endend mit den angegebenen Daten
 * @TODO bearbeitung bauen
 */

/** @var STRING $absender
 * Der Absender, automatisch aus Header-Data bestimmen!
 */
$absender = "'.header.' <'.admin_mail.'>"; // $absender = header." <".admin_mail.">";



/** @var STRING $mail_newmail_old
 * Änderung der E-Mail-Adresse, Benachrichtigung an die alte Mail-Adresse
 */
$mail_newmail_old = "'.$nmo.'";

/** @var STRING $mail_newmail_new
 * Änderung der E-Mail-Adresse, Benachrichtigung an die neue Mail-Adresse
 * %userlink% muss vorhanden sein, um Link zur Verifizierung einzufügen
 */
$mail_newmail_new = "'.$nmn.'";

/** @var STRING $mail_newmail_old_admin
 * Admin hat Mailadresse geändert - Benachrichtigung an alte Adresse
 */
$mail_newmail_old_admin = "'.$nmoa.'";

/** @var STRING $mail_newmail_new_admin
 *  Änderung der E-Mail-Adresse durch Admin, Benachrichtigung an die neue Mail-Adresse
 * %userlink% muss vorhanden sein, um Link zur Verifizierung einzufügen
 */
$mail_newmail_new_admin = "'.$nmna.'";



/** @var STRING $mail_newpass
 * Änderung des Passwortes
 */
$mail_newpass = "'.$np.'";

/** @var STRING $mail_newpass_admin
 * Admin hat Passwort geändert
 * %GeneriertesPasswort% muss vorkommen!
 */
$mail_newpass_admin = "'.$npa.'";



/** @var STRING $mail_verify
 * Mailadresse muss bestätigt werden
 */
$mail_verify = "'.$v.'";

/** @var STRING $mail_freischalten
 * Wenn ein Nutzer bestätigt wird
 */
$mail_freischalten = "'.$f.'";

/** @var STRING $mail_blockieren
 * Wenn ein Nutzer blockiert wird
 * %Begründung% muss verwendet werden
 */
$mail_blockieren = "'.$b.'";

/** @var STRING $mail_rehab
 * Blockade wurde aufgehoben
 */
$mail_rehab = "'.$r.'";

/** @var STRING $mail_accountdelete
 * Endgültiges Löschen des Accountes - ohne Daten am Ende
 */
$mail_accountdelete = "'.$a.'";



/** @var STRING $mail_newadmin
 * Wenn man als neuer Admin ernannt wird
 */
$mail_newadmin = "'.$new.'";

/** @var STRING $mail_noadmin
 * Entzug der Admin-Rechte
 */
$mail_noadmin = "'.$no.'";



/** @var STRING $mail_karten_rechnung
 * Der Text in der Mail, mit der die Rechnung als PDF kommt
 */
$mail_karten_rechnung = "'.$kr.'";

/** @var STRING $mail_zahlungda
 * Zahlung wurde erhalten
 * %RechnungsNummer% ist verwendbar
 */
$mail_zahlungda = "'.$zd.'";

/** @var STRING $mail_karten_tausch
 * Karten wurden getauscht
 * %KartenID% und %NeuerInhaber% müssen verwendet werden
 */
$mail_karten_tausch = "'.$kt.'";

/** @var STRING $mail_kartenweg
 * Kartenbestellung wurde gelöscht
 * %RechnungsNummer% und %KartenZahl% stehen zur Verfügung
 */
$mail_kartenweg = "'.$kw.'";

/** @var STRING $mail_zahlungweg
 * Zahlung wurde revidiert
 * %RechnungsNummer% und %Begründung% stehen zur Verfügung, letzteres muss verwendet werden
 */
$mail_zahlungweg = "'.$zw.'";

/** @var STRING $mail_mahnung
 * Mahnung: Geld noch nicht gezahlt
 * %RechnungsNummer% steht zur Verfügung
 */
$mail_mahnung = "'.$mm.'";




/** @var STRING $mail_reset
 * Mailtext beim Reset der Seite - ohne die Daten am Ende
 */
$mail_reset = "'.$reset.'";

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
