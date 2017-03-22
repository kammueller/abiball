<!DOCTYPE html>
<html>
<head>
	<title>Seitenerstellung</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="author" content="Matthias Kammueller">
</head>
<body>
	<?php
		if (isset($msg)) {
			echo "<h1>".$msg."</h1>";
		}
	?>

	<form action="3.php" method="post">
        <h2>Login-Daten</h2>
		Um Ihnen Zugang zur Website zu garantieren, ben&ouml;tigen wir die folgenden Daten<br>
		<table border="1">
			<tr><td>Vorname: </td><td> <input type="text" name="host" size="64" title="Vorname"></td></tr>
			<tr><td>Nachname: </td><td> <input type="text" name="user" size="64" title="Nachname"></td></tr>
			<tr><td>Mail-Adresse: </td><td> <input type="text" name="db" size="64" title="Mail-Adresse"></td></tr>
			<tr><td>Passwort: </td><td> <input type="password" name="pass" size="64" title="Passwort"></td></tr>
		</table>
        <h2>Webseiten-Daten</h2>
        <table border="1">
            <tr><td colspan="2">Adresse des Admins</td></tr>
            <tr><td>Stra&szlig;e: </td><td> <input type="text" name="str" size="64" title="Strasse" placeholder="Musterstr. 9"></td></tr>
            <tr><td>Ort: </td><td> <input type="text" name="ort" size="64" title="Ort" placeholder="12345 Musterhausen"></td></tr>
            <tr><td colspan="2">Titel-Informationen (Beispiel siehe unten) </td></tr>
            <tr><td>HTML-Seitentitel*: </td><td> <input type="text" name="html" size="64" title="html-title" placeholder="Abiball 2015"></td></tr>
            <tr><td>Webadresse des Inhaltes** mit "https://": </td><td> <input type="text" name="adress2" size="64" title="Web-Adresse Inhalt" placeholder="https:/kammueller.eu"></td></tr>
            <tr><td>Erste Header-Zeile: </td><td> <input type="text" name="header1" size="64" title="Header 1" placeholder="Abiball 2015 LMGU"></td></tr>
            <tr><td>Erste Header-Zeile: </td><td> <input type="text" name="header2" size="64" title="Header 2" placeholder="27. Juni 2015 &bull; Backstage M&uuml;nchen"></td></tr>
			<tr><td colspan="2">Captcha-Codes (Beziehen Sie von <a href="https://www.google.com/recaptcha/admin#list">https://www.google.com/recaptcha/admin#list</a> </td></tr>
            <tr><td>Websiteschl&uuml;ssel: </td><td> <input type="text" name="cap1" size="64" title="Captcha1"></td></tr>
            <tr><td>Geheimer Schl&uuml;ssel: </td><td> <input type="text" name="cap2" size="64" title="Captcha2"></td></tr>
        </table>
		<input type="submit" value="Verbindung herstellen"><br><br>
		<img src="bild.png"><br>
        _________________________________<br>
        *) Der Ordner /abiball muss mit einer Domain verbunden werden, die SSL-Verschl&uuml;sselt ist.<br>
        **) Der Titel der in den Browserfenstern angezeigt wird
	</form>
</body>
</html>