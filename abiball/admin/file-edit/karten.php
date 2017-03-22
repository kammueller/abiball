<?php

include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../../home.php'); exit; }

include('../../back-end/design_alpha.inc.php');
include('../../back-end/design_beta.inc.php');
include('../../back-end/db_captcha.php');


include ('../../back-end/txt/karten_links.php');

echo '<form method="post" action="karten_aendern.php">
<h1>Kartenbestellung - Index</h1>
Wenn man Karten reserviert hat (Nachbestellphase):<br>
<textarea name="i_res" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $karten_index_reserviert).'</textarea> <br>
<span style="font-size: 12pt;">%link*%nachbestellen% muss enthalten sein</span><br><br>

Wenn man in der ersten Runde Karten bestellen kann: <br>
<textarea name="i_erste" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $karten_index_ersterunde).'</textarea> <br>
<span style="font-size: 12pt;">%link*%bestellen% muss enthalten sein</span><br><br>

Wenn man Karten nachbestellen kann:
<textarea name="i_nach" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $karten_index_nachbestellen).'</textarea> <br>
<span style="font-size: 12pt;">%link*%nachbestellen% muss enthalten sein</span><br><br>

<br>Kartentausch:<br>
<textarea name="i_tausch" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $karten_index_tauschen).'</textarea> <br>
<span style="font-size: 12pt;">%link*%tauschen% muss enthalten sein</span><br><br>

<br><h1>Kartenbestellung - Rechnung</h1>
<textarea name="bestell" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $karten_bestellung_rechnung).'</textarea> <br>
<span style="font-size: 12pt;">%link*%rechnungen% muss enthalten sein; %RechnungsNummer% kann verwendet werden</span><br><br>';

// CAPTCHA
require_once('recaptchalib.php');
$publickey = publickey;
echo recaptcha_get_html($publickey, null, true);

echo 'Passwort: <input type="password" name="pass"><br>
    <input type="submit" value="Daten speichern">
    <button type="button" onclick="window.location = \'bausteine.php\' ;">Abbrechen</button>
    </form>';

include ('../../back-end/design_gamma.inc.php');

