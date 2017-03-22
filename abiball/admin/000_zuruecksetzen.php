<?php
include('../back-end/logincheck.inc.php');
header ('Content-type: text/html; charset=utf-8');
if (!isset($loggedIn)) { $message = encode($error_login); include ('../login.php'); exit; }
if ($loggedIn != "speak Friend and Enter") { $message = encode($error_login); include ('../login.php'); exit; }
if (!isset($zugriff)) { header('location: ../home.php'); exit; } if ( $zugriff != 'all' ) { header('location: ../home.php'); exit; }

include ('../back-end/db_captcha.php');

echo ('
<!doctype html>
<html>
	<head>
		<title>Zur&uuml;cksetzen</title> 
	</head>
	<body>
	<form name="Zurueck" action="001_zuruecksetzen.php" method="post">
	<b>Bitte gib deine Daten ein, auf die dein erster Administratoren-Account erstellt werden wird:</b><br>
	<table><tbody>
	    <tr>
	        <td>Vorname:</td>
	        <td><input type="text" size="32" maxlength="32" name="Vorname"></td>
	    </tr> <tr>
	        <td>Nachname:</td>
	        <td><input type="text" size="32" maxlength="32"	name="Nachname"></td>
	    </tr> <tr>
	        <td>E-Mail-Adresse:</td>
	        <td><input type="text" size="32" maxlength="64"	name="mail"></td>
	    </tr> <tr>
	        <td>Passwort:</td>
	        <td><input type="password" size="32" maxlength="64"	name="passwort"></td>
	    </tr>
    </tbody></table>
    <br>
	
	<b>Um die Website zur&uuml;cksetzen zu d&uuml;rfen, benötigst du das Administrations-Passwort:</b><br>
	<input type="password" size="32" maxlength="64"
	name="adminPW"><br><br>');

	// CAPTCHA
    require_once('file-edit/recaptchalib.php');
    $publickey = publickey;
    echo recaptcha_get_html($publickey, null, true);

	echo ('<input type="submit" value="Website zurücksetzen">
	</form>
	</body>
</html>



');
