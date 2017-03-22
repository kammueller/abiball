<?php

include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../../home.php'); exit; }

include('../../back-end/design_alpha.inc.php');
include ('../../back-end/design_beta.inc.php');


// Auswahl-Menü
if (!isset($_GET["datei"])) {
    echo '<h1>Seiten-Bearbeitung</h1>
    Zu bearbeitende Seite:
        <select name="sortorderselectbox" onchange="document.location = this.value">
            <option value="bausteine.php"> -- Bitte wählen -- </option>
            <option value="bausteine.php?datei=about.php">Impressum</option>
            <option value="bausteine.php?datei=blog.php">Blog</option>
            <option value="bausteine.php?datei=cookie.php">Login & Logout</option>
            <option value="bausteine.php?datei=eintragen.php">Neuen Nutzer anlegen</option>
            <option value="bausteine.php?datei=essen.php">(Essens)-Menü</option>
            <option value="bausteine.php?datei=location.php">Die Location</option>
            <option value="bausteine.php?datei=login.php">Anmelde-Seite</option>
            <option value="bausteine.php?datei=karten1.php">Karten-Bestellung (Fix-Texte 1)</option>
            <option value="bausteine.php?datei=karten2.php">Karten-Bestellung (Fix-Texte 2)</option>
            <option value="bausteine.php?datei=karten3.php">Rechnungen</option>
            <option value="bausteine.php">--- --- ---</option>
            <option value="errors.php">Fehlermeldungen</option>
            <option value="karten.php">Karten-Bestellung (Interaktive Texte)</option>
            <option value="mail.php">E-Mails</option>
        </select>';
    include ('../../back-end/design_gamma.inc.php');
    exit;
}


include('../../back-end/db_captcha.php');

/** @var STRING $file
 * Das zu bearbeitende Dokument*/
$file = '../../back-end/txt/pages/'.mysqli_real_escape_string( $db_link, esc($_GET["datei"]));

if(!is_file($file)) {echo '<h1>Fehler - Datei kann nicht gefunden werden</h1><a href="bausteine.php">Zurück</a>'; exit;}

include ($file);

echo '<form method="post" action="bausteine_aendern.php"><h1>Bearbeitung '.$_GET["datei"].'</h1>';
foreach ($bausteine as $id => $baustein) {
    echo $descript[$id].": <br>";
    echo '<textarea name="textbaustein'.$id.'" style="width: 90%;" rows=5>'.str_ireplace("%nZ%", "\n", $baustein).'</textarea> <br>';
}
// CAPTCHA
    require_once('recaptchalib.php');
    $publickey = publickey;
    echo recaptcha_get_html($publickey, null, true);

echo 'Passwort: <input type="password" name="pass"><br>
    <input type="hidden" name="datei" value="'.mysqli_real_escape_string( $db_link, esc($_GET["datei"])).'"><input type="submit" value="Daten speichern">
    <button type="button" onclick="window.location = \'bausteine.php\' ;">Abbrechen</button>
    </form>';

include ('../../back-end/design_gamma.inc.php');

