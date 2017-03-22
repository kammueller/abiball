<?php

include('../../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../../home.php'); exit; }

include('../../back-end/design_alpha.inc.php');
include('../../back-end/design_beta.inc.php');
include('../../back-end/db_captcha.php');


include ('../../back-end/txt/mail.php');


echo '<form method="post" action="mail_aendern.php">
<h1>Bearbeitung Mailtexte</h1>
Sämtliche E-Mails beginnen mit "Hallo [Vorname], %nZ%%nZ%" und enden mit den angegebene Daten.<br>
<br>
<h2>Änderung der Mailadresse</h2>
<b>Durch einen selber</b><br>
Benachrichtigung an alte Mail-Adresse:<br>
<textarea name="nmo" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_newmail_old).'</textarea> <br>
<br>

Benachrichtigung an neue Mail-Adresse<br>
<textarea name="nmn" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_newmail_new).'</textarea> <br>
<span style="font-size: 12pt;">%userlink% muss enthalten sein</span><br><br>

<br>
<b>Durch einen Administrator</b><br>
Benachrichtigung an alte Mail-Adresse:<br>
<textarea name="nmoa" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_newmail_old_admin).'</textarea> <br>
<br>

Benachrichtigung an neue Mail-Adresse<br>
<textarea name="nmna" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_newmail_new_admin).'</textarea> <br>
<span style="font-size: 12pt;">%userlink% muss enthalten sein</span><br><br>

<br><br>
<h2>Änderung des Passwortes</h2>
<b>Durch einen selber</b><br>
<textarea name="np" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_newpass).'</textarea> <br>
<br>

<b>Durch einen Administrator</b><br>
<textarea name="npa" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_newpass_admin).'</textarea> <br>
<span style="font-size: 12pt;">%GeneriertesPasswort% muss enthalten sein</span><br><br>

<br><br>
<h2>Accountbestätigung etc</h2>
Bestätigung der Mail-Adrsse:<br>
Benachrichtigung an neue Mail-Adresse<br>
<textarea name="v" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_verify).'</textarea> <br>
<span style="font-size: 12pt;">%userlink% muss enthalten sein</span><br><br>

Freischaltung des Accounts<br>
<textarea name="f" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_freischalten).'</textarea> <br>
<br>

Nutzer wurde Blockiert<br>
<textarea name="b" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_blockieren).'</textarea> <br>
<span style="font-size: 12pt;">%Begründung% muss enthalten sein</span><br><br>

Blockade wurde aufgehoben<br>
<textarea name="r" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_rehab).'</textarea> <br>
<br>

Account wurde gelöscht<br>
<textarea name="a" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_accountdelete).'</textarea> <br>
<br>

<br><br>
<h2>Administratorrechte</h2>
... wurden anerkannt:<br>
<textarea name="new" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_newadmin).'</textarea> <br>
<br>

... wurden aberkannt:<br>
<textarea name="no" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_noadmin).'</textarea> <br>
<br>

<br><br>
<h2>Kartenbestellung</h2>
Bestätigung der Bestellung, Rechnungsversand:<br>
<textarea name="kr" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_karten_rechnung).'</textarea> <br>
<br>

Zahlung wurde erhalten<br>
<textarea name="zd" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_zahlungda).'</textarea> <br>
<span style="font-size: 12pt;">%RechnungsNummer% ist verwendbar</span><br><br>

Kartentausch<br>
<textarea name="kt" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_karten_tausch).'</textarea> <br>
<span style="font-size: 12pt;">%KartenID% und %NeuerInhaber% müssen verwendet werden</span><br><br>

Bestellung wurde gelöscht<br>
<textarea name="kw" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_kartenweg).'</textarea> <br>
<span style="font-size: 12pt;">%RechnungsNummer% und %KartenZahl% sind verwendbar</span><br><br>

Zahlung wurde gelöscht<br>
<textarea name="zw" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_zahlungweg).'</textarea> <br>
<span style="font-size: 12pt;">%Begründung% muss verwendet werden, %RechnungsNummer% kann verwendet werden</span><br><br>

Mahnung (Rechnung wurde noch nicht beglichen)<br>
<textarea name="mm" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_mahnung).'</textarea> <br>
<span style="font-size: 12pt;">%RechnungsNummer% kann verwendet werden</span><br><br>

<br><br>
<h2>Seite wird zurückgesetzt</h2>
<textarea name="reset" style="width: 90%;" rows=3>'.str_ireplace("%nZ%", "\n", $mail_reset).'</textarea> <br>
<br>
';

// CAPTCHA
require_once('recaptchalib.php');
$publickey = publickey;
echo recaptcha_get_html($publickey, null, true);

echo 'Passwort: <input type="password" name="pass"><br>
    <input type="submit" value="Daten speichern">
    <button type="button" onclick="window.location = \'bausteine.php\' ;">Abbrechen</button>
    </form>';

include ('../../back-end/design_gamma.inc.php');

