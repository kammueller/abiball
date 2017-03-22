<?php

include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../../home.php'); exit; }

include('../../back-end/design_alpha.inc.php');
include('../../back-end/design_beta.inc.php');
include('../../back-end/db_captcha.php');


include ('../../back-end/txt/errors.php');

echo '<form method="post" action="errors_aendern.php"><h1>Bearbeitung Fehlermeldungen</h1>
<table>
    <tr><td>Datenbank-Verbindungsfehler:</td>   <td><input type="text" name="db" value="'.$error_db.'" size="64"></td></tr>
    <tr><td>Man muss angemeldet sein:</td>      <td><input type="text" name="login" value="'.$error_login.'" size="64"></td></tr>
    <tr><td>10-Minuten-Fehler:</td>             <td><input type="text" name="session" value="'.$error_session.'" size="64"></td></tr>
    <tr><td>Falscher Benutzename/Passwort</td>  <td><input type="text" name="pw" value="'.$error_pw.'" size="64"></td></tr>
</table>
Cookies können nicht gesetzt werden: <br>
<textarea name="cookie" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $error_cookie).'</textarea> <br>
Mail konnte nicht versendet werden: <br>
<textarea name="mail" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $error_mail).'</textarea> <br>';

// CAPTCHA
require_once('recaptchalib.php');
$publickey = publickey;
echo recaptcha_get_html($publickey, null, true);

echo 'Passwort: <input type="password" name="pass"><br>
    <input type="submit" value="Daten speichern">
    <button type="button" onclick="window.location = \'bausteine.php\' ;">Abbrechen</button>
    </form>';

include ('../../back-end/design_gamma.inc.php');

